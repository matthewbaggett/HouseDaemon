<?php
function examplify($pattern) {

  $pattern = str_replace("(/:response_mode)", "/json", $pattern);
  return $pattern;
}

$app->get(
  '/',
  function () use ($app) {
    //session_require_auth();

    $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>LoneSatoshi API</title>
            <style type="text/css" media="all">
              @import url("http://lonesatoshi.com/themes/LoneSatoshi/css/api.css");
            </style>
        </head>
        <body>
            <header>
                <a href="http://lonesatoshi.com/">LoneSatoshi API</a>
            </header>
            <h1>LoneSatoshi REST API documentation!</h1>
            <p>
                Better documentation to come soon.
            </p>
            <section>
                <h2>Endpoints</h2>
                <ul>
                  %%ENDPOINTS%%
                </ul>
                <div class="clear"></div>
            </section>

        </body>
    </html>
EOT;

    // Hack out the routes from the Slim underlaying system using reflection
    $myClassReflection = new ReflectionClass(get_class($app->router()));
    $secret = $myClassReflection->getProperty('routes');
    $secret->setAccessible(true);

    // Generate routes array
    $routes = array();
    $endpoints_html = array();
    foreach ($secret->getValue($app->router()) as $route) {
      /* @var $route \Slim\Route */
      $key = trim($route->getPattern());
      $routes[$key] = $route;
    }

    // Sort the Routes
    ksort($routes);

    // Display the routes
    foreach ($routes as $route) {
      /* @var $route \Slim\Route */

      $example = examplify($route->getPattern());
      $root_path = dirname($_SERVER['SCRIPT_NAME']);
      if($root_path == "\\"){
        $root_path = '';
      }

      $example_url = $root_path . "/" . str_replace("/json", "/human", $example);
      $methods = implode(" | ", $route->getHttpMethods());

      // Build HTML
      $endpoint_html = array();
      $endpoint_html[] = "<dl>";
      $endpoint_html[] = "  <dt>Name</dt>";
      $endpoint_html[] = "  <dd>{$route->getName()}</dd>";
      $endpoint_html[] = "  <dt>Pattern</dt>";
      $endpoint_html[] = "  <dd>{$methods} {$route->getPattern()}</dd>";
      $endpoint_html[] = "  <dt>Example</dt>";
      $endpoint_html[] = "  <dd><a href=\"{$example_url}\">{$example}</a></dd>";
      $endpoint_html[] = "</dl>";

      $endpoints_html[] = implode('', $endpoint_html);
    }

    $template = str_replace('%%ENDPOINTS%%', "<li>" . implode("</li><li>", $endpoints_html) . "</li>", $template);
    echo $template;
  }
);