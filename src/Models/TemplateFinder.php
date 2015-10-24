<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:29
 */

namespace Exposia\Navigation\Models;

use Illuminate\Config\Repository;
use Exposia\Navigation\Exceptions\TemplateNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class TemplateFinder
{

    protected $templates_dir;
    protected $base_dir;

    private $config;
    private $files;

    public function __construct(Repository $config, Filesystem $files)
    {
        $this->config = $config;

        $this->files = $files;

        $views_dir = $this->config->get('view.paths');

        $this->base_dir = $views_dir[0] . "/" . $this->config->get('theme.name');

        $this->templates_dir = $this->base_dir . "/pages";
    }

    /**
     * Return all templates in array form
     * @return array
     */
    public function getTemplates()
    {
        $folders = $this->files->directories($this->templates_dir);
        $templates = [];

        foreach ($folders as $folder) {
            $folder_name = str_replace($this->templates_dir . "/", "", $folder);
            $templates[$folder_name] = "data:image/jpeg;base64," . base64_encode(file_get_contents($folder . '/preview.jpg'));
        }

        return $templates;
    }

    /**
     * Returns the main templates
     * @return mixed
     */
    public function getMainTemplates()
    {
        $files = File::files($this->templates_dir);
        foreach ($files as $file) {
            $file_array = explode("/", $file);
            $file_piece = end($file_array);
            $file = str_replace(".blade.php", "", $file_piece);
            $files_array[$file] = $file;
        }

        return $files_array;
    }

    /**
     * Determine if a template exists
     *
     * @param $template_name
     *
     * @return bool
     */
    public function templateExists($template_name)
    {
        if (!isset($template_name) || !$this->files->exists($this->templates_dir . '/' . $template_name)) {
            return false;
        }

        return true;
    }

    /**
     * @param $template_name
     *
     * @return string
     * @throws TemplateNotFoundException
     */
    public function readTemplate($template_name)
    {
        if (!$this->templateExists($template_name)) {
            throw new TemplateNotFoundException('Template \'' . $template_name . '\' not found');
        }

        return file_get_contents($this->templates_dir . '/' . $template_name . '/template.blade.php');
    }

    /**
     * @param $template_name
     *
     * @return mixed
     * @throws TemplateNotFoundException
     */
    public function readConfig($template_name)
    {
        if (!$this->templateExists($template_name)) {
            throw new TemplateNotFoundException('Template \'' . $template_name . '\' not found');
        }

        return json_decode(file_get_contents($this->templates_dir . "/" . $template_name . "/config.json"));
    }
}