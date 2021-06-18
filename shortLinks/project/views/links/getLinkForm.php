<?php
    require_once __DIR__."\..\..\classes\ShortUrl.php";

    if($_POST){
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=shortLinks",'root', '');
        }catch(PDOException $e){
            print "Error!:" . $e->getMessage() . "<br/>";
            die();
        }
        $shortLink = new ShortUrl($pdo);
        try {
            $shortLink->urlToShortCode($_POST['link']);
        } catch (Exception $e) {
            print "Error!:" . $e->getMessage() . "<br/>";
            die();
        }
    }
?>
<section class="getLinkForm">
    <div class="container-md">
        <form method="post">
            <div class="mb-3">
                <label for="link" class="form-label">Write a link below</label>
                <input type="text" class="form-control" id="link" name="link" placeholder="Write a link here">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>








