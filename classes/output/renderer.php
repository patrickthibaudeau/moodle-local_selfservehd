<?php
/**
 * *************************************************************************
 * *                     Norquest Curriculum Settings                     **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  selfservehd                                               **
 * @name        Norquest Curriculum Settings                              **
 * @copyright   Oohoo IT Services Inc.                                    **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @author      Kais Abid                                                 **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace local_selfservehd\output;
/**
 * Description of renderer
 *
 * @author patrick
 */
class renderer extends \plugin_renderer_base {
    
    public function render_dashboard(\templatable $dashboard) {
        $data = $dashboard->export_for_template($this);
        return $this->render_from_template('local_selfservehd/dashboard', $data);
    }
    
    public function render_faqs(\templatable $faqs) {
        $data = $faqs->export_for_template($this);
        return $this->render_from_template('local_selfservehd/faqs', $data);
    }

    
}

