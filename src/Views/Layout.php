<?php

namespace Views;

class Layout
{
    protected $title;
    protected $body;
    protected $homeActive;

    public function __construct(string $title, callable $body, bool $homeActive = false)
    {
        $this->title = $title;
        $this->body = $body;
        $this->homeActive = $homeActive;
    }

    public function __invoke()
    {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Red social estilo Twitter - Conecta con nuevos usuarios">
    <meta name="theme-color" content="#1da1f2">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="/css/bootstrap.min.css" as="style">
    <link rel="preload" href="/css/twitter.css" as="style">
    
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/twitter.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🐦</text></svg>">
    
    <title><?= htmlspecialchars($this->title) ?></title>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <span style="font-size: 1.2em;">🐦</span> TwitterClone
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li<?php if ($this->homeActive) echo ' class="active"' ?>>
                        <a href="/">
                            <span class="glyphicon glyphicon-home"></span> Inicio
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container" style="margin-top: 80px;">
        <div class="row">
            <?= ($this->body)(); ?>
        </div>
    </main>

    <!-- Scripts al final para mejor performance -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    }
}
