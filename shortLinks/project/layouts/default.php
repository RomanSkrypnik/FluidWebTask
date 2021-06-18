<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body class="bg-dark">
<header class="header">
    <div class="container-md pt-3 pb-2">
        <div class="row align-items-center justify-content-between">
            <a href="/" class="header__logo col h1" style="font-size: 24px; text-decoration: none">ShortMyLink</a>
            <nav class="header__menu col align-self-end">
                <ul class="header__list row justify-content-end">
                    <a href="/show/" class="col-3 btn btn-success" style="text-decoration: none">Show all links</a>
                </ul>
            </nav>
        </div>
    </div>
</header>
<main class="main">
    <?php echo $content ?>
</main>
</body>
</html>
