<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $sitename ?? ''; ?><?= isset($pagetitle) ? (' - ' . $pagetitle) : ''; ?></title>
    <meta name="robots" content="index,follow">
    <meta name="description" content="Vous cherchez une nounou pour garder vos enfants ? On est là pour vous aider ! Ce site vous mets en relation avac une assistante maternelle.">
    <meta name="author" content="Aymeric Anger, Nargis Ayyobi">
    <meta name="keywords" content="babysitter, nounou, assistant maternel, assistante maternelle, dailysitter">

    <link rel="shortcut icon" href="./assets/pictures/logo/logox32.png" sizes="32x32" type="image/png">
    <link rel="apple-touch-icon" href="./assets/pictures/logo/logox32.png" sizes="32x32" type="image/png">


    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preload" as="script" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- LibraryAOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 



    <link rel="stylesheet" href="./assets/app.css">
    <script src="./assets/app.js" type="module" defer></script>

    <!-- PWA -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#ffffff">
    <!-- Register Service Worker -->
    <script>
        if ("serviceWorker" in navigator)
        {
            navigator.serviceWorker.register("service-worker.js")
                .then(e => console.log("Service worker registered", e))
                .catch(e => console.log("service worker failed", e));
        }
    </script>
</head>
<body>
    <?= $content; ?>
    <?php include __DIR__ . '/sprite.svg'; ?>
</body>
</html>