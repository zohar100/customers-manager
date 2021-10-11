<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles/app.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <title>CRUD Products</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Customer Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: space-between;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (!isset($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] === '/form') echo 'active'; ?>" href="/form">Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] === '/customers') echo 'active'; ?>" href="/customers">customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] === '/dashboard') echo 'active'; ?>" href="/dashboard">dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div id="messages"> </div>
        <?php echo $content; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>