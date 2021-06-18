<?php


class ShortUrl{
    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
    protected static $linksTable = "links";
    protected static $usersTable = "users";
    protected static $checkUrlExists = true;

    protected $pdo;
    protected $timestamp;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function urlToShortCode($url){
        if(empty($url)){
            throw new \Exception("Не получен адрес URL.");
        }

        if($this->validateUrlFormat($url) == false){
            throw new \Exception("Адрес URL имеет неправильный формат.");
        }

        if(self::$checkUrlExists){
            if(!$this->verifyUrlExists($url)){
                throw new \Exception("Адрес URL не существует.");
            }
        }

        $shortCode = $this->urlExistsInDb($url);

        if($shortCode == false){
            $shortCode = $this->createShortCode($url);
        }

        return $shortCode;
    }

    protected function validateUrlFormat($url){
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    protected function verifyUrlExists($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return(!empty($response) && $response !=404);
    }

    protected function urlExistsInDb($url){
        $query = "SELECT short_link FROM ".self::$linksTable." WHERE primal_link = :primal_link LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = [
            "primal_link" => $url
        ];
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result) ? false : $result['short_link']);
    }

    protected function createShortCode($url){
        $id = $this->insertUrlInDb($url);
        $shortCode = $this->convertIntToShortCode($id);
        $this->insertShortCodeInDb($id, $shortCode);
        return $shortCode;
    }


    protected function insertUrlInDb($url) {

        $query = "INSERT INTO " . self::$linksTable . " (primal_link, timestamp) " . " VALUES (:primal_link, :timestamp)";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "primal_link" => $url,
            "timestamp" => $this->timestamp
        );
        $stmt->execute($params);

        return $this->pdo->lastInsertId();
    }


    protected function convertIntToShortCode($id){
        $id = intval($id);
        if ($id < 1){
            throw new \Exception("ID не является некорректным целым числом.");
        }

        $length = strlen(self::$chars);

        if($length < 10){
            throw new \Exception("Длина строки мала");
        }

        $code = "";

        while($id > $length - 1){
            $code = $code = self::$chars[fmod($id, $length)] .
                $code;
            $id = floor($id / $length);
        }

        $code = self::$chars[$id].$code;

        return $code;
    }

    protected function insertShortCodeInDb($id, $code){
        if($id == null || $code == null){
            throw new \Exception("Параметры ввода неправильные.");
        }

        $query = "UPDATE " . self::$linksTable . " SET short_link = :short_link WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = [
            'id' => $id,
            'short_link' => $code
        ];
        $stmt->execute($params);

        if($stmt->rowCount() < 1){
            throw new \Exception("Строка не обновляется коротким кодом.");
        }

        return true;
    }

    public function shortCodeToUrl($code, $increment = true){
        if(empty($code)){
            throw new \Exception("Не задан короткий код");
        }

        if($this->validateShortCode($code) == false){
            throw new \Exception("Короткий код имеет неправильный формат");
        }

        $urlRow = $this->getUrlFromDb($code);

        if(empty($urlRow)){
            throw new \Exception("Короткий код не содержится в базе.");
        }

        if($increment == true){
            $this->incrementCounter($urlRow['id']);
        }

        $this->addUserToDb($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $this->timestamp);

        return $urlRow['primal_link'];
    }

    protected function validateShortCode($code){
        return preg_match("|[" . self::$chars . "]+|", $code);
    }

    protected function getUrlFromDb($code){
        $query = "SELECT id, primal_link FROM " . self::$linksTable ." WHERE short_link = :short_link LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = [
            "short_link" => $code
        ];
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($stmt) ? false : $result);
    }

    protected function incrementCounter($id){
        $query = "UPDATE " . self::$linksTable . " SET counter = counter + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = [
            "id" => $id
        ];
        $stmt->execute($params);
    }

    protected function addUserToDb($ip, $userAgent, $timestamp){
        $query = "INSERT INTO ".self::$usersTable." (ip,userAgent, timestamp) VALUES(:ip,:userAgent,:timestamp)";
        $stmt  = $this->pdo->prepare($query);
        $params = [
          'ip' => $ip,
          'timestamp' => $timestamp,
           'userAgent' => $userAgent
        ];
        $stmt->execute($params);
    }
}

