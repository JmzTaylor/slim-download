<?php
namespace SimoTod\SlimDownload;

class DownloadView extends \Slim\View 
{
    public function render($path, $data = NULL) 
    {
        $app = \Slim\Slim::getInstance();

        $app->response->setStatus(200);
        $app->response()->header('Content-Type', 'application/octet-stream');
        $app->response()->header('Content-Transfer-Encoding', 'Binary');
        $app->response()->header('Content-disposition', 'attachment; filename="'.basename($path).'"');
        $app->response()->header('Content-Length', filesize($path));
        $app->response()->header('Expires', '0');
        $app->response()->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        $app->response()->header('Pragma', 'public');

        ob_clean();
        ob_start();
        readfile($path);
        $content = ob_get_contents();

        $app->response()->body($content);

        $app->stop();
    }
}