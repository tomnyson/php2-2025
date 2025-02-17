<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Jenssegers\Blade\Blade;

class BladeServiceProvider
{
    public static function render($view, $data = [])
    {
        $views = realpath(__DIR__ . '/../view');
        $cache = realpath(__DIR__ . '/../cache');
    
        if (!$views || !$cache) {
            die("Blade Error: Views or cache directory is missing.");
        }
    
        try {
            array_map('unlink', glob($cache . '/*'));
            $blade = new Blade($views, $cache);
    
            // Debug: Check if the view exists
            $viewFile = $views . '/' . str_replace('.', '/', $view) . '.blade.php';
            if (!file_exists($viewFile)) {
                die("Blade Error: View file '$viewFile' not found.");
            }
            $html = $blade->make($view, $data)->render();
            // Debug: Output rendered HTML
    
            echo $html;
        } catch (Exception $e) {
            die("Blade Error: " . $e->getMessage());
        }
    }
}