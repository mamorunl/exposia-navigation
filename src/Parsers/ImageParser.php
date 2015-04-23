<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 11:30
 */

namespace mamorunl\AdminCMS\Navigation\Parsers;


class ImageParser implements ParserInterface {
    /**
     * @var
     */
    private $xpo_id;
    /**
     * @var
     */
    private $json_data;

    /**
     * @param $xpo_id
     * @param $json_data
     */
    public function __construct($xpo_id, $json_data)
    {

        $this->xpo_id = $xpo_id;
        $this->json_data = $json_data;
    }

    public function parseForForms($values = [])
    {
        $attributes = $this->getAttributes();
        $values = $this->getValues($values);

        $value = "<img src=\"" . $values['src'] . "\" alt=\"\" id=\"" . $this->xpo_id . "\">";

        $modal = $this->getModalHTML($this->xpo_id, $values);

        return "
        <div style=\"overflow: hidden; display: block;\">
            <a href=\"#modal_" . $this->xpo_id . "\" data-toggle=\"modal\" data-target=\"#modal_" . $this->xpo_id . "\" style=\"display: block;" . $attributes . "\">" .
        $value . "
            </a>
        </div>" . $modal;
    }

    public function parseForDatabase()
    {
        // TODO: Implement parseForDatabase() method.
    }

    public function parseForDisplay()
    {
        // TODO: Implement parseForDisplay() method.
    }

    private function getAttributes()
    {
        $attributes = "";
        if (isset($this->object->height)) {
            $attributes .= "height: " . $this->object->height . "px;";
        }

        if (isset($this->object->width)) {
            $attributes .= "width: " . $this->object->width . "px;";
        }

        return $attributes;
    }

    /**
     * @param array $default
     *
     * @return array
     */
    private function getValues($default = [])
    {
        return [
            'src'    => (isset($default['src']) ? $default['src'] : "http://lorempixel.com/{$this->object->width}/{$this->object->height}"),
            'alt'    => (isset($default['alt']) ? $default['alt'] : ""),
            'href'   => (isset($default['href']) ? $default['href'] : ""),
            'title'  => (isset($default['title']) ? $default['title'] : ""),
            'target' => (isset($default['target']) ? $default['target'] : "")
        ];
    }

    private function getModalHTML($key, $img) {
        $modal = '
        <div class="modal fade" id="modal_' . $key . '" tabindex="-1" role="dialog" aria-labelledby="modal_' . $key . '" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="' . trans('admincms::global.close') . '"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_' . $key . '">' . trans('admincms-navigation::parsers.image.title') . '</h4>
              </div>
              <div class="modal-body clearfix">
                <div class="col-md-4">
                    <img src="' . (isset($img['src']) ? $img['src'] : "") . '" alt="" class="img-responsive" id="preview_image_' . $key . '">
                    <div class="file-select btn btn-primary btn-block">
                        ' . trans('admincms-navigation::parsers.image.select_file') . '
                        <input type="file" id="upload_' . $key . '" class="form-control" name="' . $key . '" onchange="changepreview' . $key . '();">
                    </div>
                </div>
                <div class="col-md-8">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#image-tab" data-toggle="tab" role="tab"><i class="fa fa-picture-o"></i> ' . trans('admincms-navigation::parsers.image.tabs.image') . '</a>
                            </li>
                            <li role="presentation">
                                <a href="#link-tab" data-toggle="tab" role="tab"><i class="fa fa-external-link"></i> ' . trans('admincms-navigation::parsers.image.tabs.link') . '</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="image-tab" role="tabpanel">
                                <div class="form-group">
                                    <label>' . trans('admincms-navigation::parsers.image.fields.alt') . '</label>
                                    <input type="text" name="' . $key . '_alt" class="form-control" value="' . (isset($img['alt']) ? $img['alt'] : "") . '">
                                </div>
                            </div>

                            <div class="tab-pane" id="link-tab" role="tabpanel">
                                <div class="form-group">
                                    <label>' . trans('admincms-navigation::parsers.image.fields.href') . '</label>
                                    <input type="text" name="' . $key . '_href" class="form-control" value="' . (isset($img['href']) ? $img['href'] : "") . '">
                                </div>

                                <div class="form-group">
                                    <label>' . trans('admincms-navigation::parsers.image.fields.target') . '</label>
                                    <select name="' . $key . '_target" class="form-control">
                                        <option value="_self"' . (isset($img['target']) && $img['target'] == "_self" ? " selected" : "") . '>' . trans('admincms-navigation::parsers.image.fields.target_self') . '</option>
                                        <option value="_blank"' . (isset($img['target']) && $img['target'] == "_blank" ? " selected" : "") . '>' . trans('admincms-navigation::parsers.image.fields.target_blank') . '</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>' . trans('admincms-navigation::parsers.image.fields.title') . '</label>
                                    <input type="text" name="' . $key . '_title" class="form-control" value="' . (isset($img['title']) ? $img['title'] : "") . '">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">' . trans('admincms::global.close') . '</button>
              </div>
            </div>
          </div>
        </div>';

        $js = '
<script>
    function changepreview' . $key . '() {
        var gFileReader = new FileReader();
        gFileReader.readAsDataURL(document.getElementById("upload_' . $key . '").files[0]);

        gFileReader.onload = function(gFileReaderEvent) {
                document.getElementById("preview_image_' . $key . '").src = gFileReaderEvent.target.result;
                document.getElementById("' . $key . '").src = gFileReaderEvent.target.result;
        }
    }
</script>';

        return $modal . $js;
    }
}