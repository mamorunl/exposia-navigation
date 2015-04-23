<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:29
 */

namespace mamorunl\AdminCMS\Navigation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;
use mamorunl\AdminCMS\Navigation\Exceptions\TemplateNotFoundException;

class TemplateFinder
{

    protected $templates_dir;

    private $config;
    private $files;

    public function __construct(Repository $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;

        $views_dir = $this->config->get('view.paths');
        $this->templates_dir = $views_dir[0] . "/" . $this->config->get('theme.name') . "/pages";
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
     * Determine if a template exists
     *
     * @param $template_name
     *
     * @return bool
     */
    public function templateExists($template_name)
    {
        if (!$this->files->exists($this->templates_dir . '/' . $template_name)) {
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
        if(!$this->templateExists($template_name)) {
            throw new TemplateNotFoundException;
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
        if(!$this->templateExists($template_name)) {
            throw new TemplateNotFoundException;
        }

        return json_decode(file_get_contents($this->templates_dir . "/" . $template_name . "/config.json"));
    }
}