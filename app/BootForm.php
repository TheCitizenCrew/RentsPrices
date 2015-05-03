<?php

/**
 * http://www.grafikart.fr/tutoriels/laravel/formulaire-bootstrap-laravel-508
 * https://gist.github.com/Grafikart/8df859a15ebb98c709c8
 */
namespace Grafikart;

use \Form;

class BootForm {

    private $placeholder = false;

    public function __construct($form, $session){
        $this->form = $form;
        $this->session = $session;
    }

    public function open($model, array $options = array()){
        $controller_name = str_plural(get_class($model)) . 'Controller';
        if ($model->id) {
            $options['method'] = 'PUT';
            if (!isset($options['action'])) {
                $options['action'] = ["$controller_name@update", $model->id];
            }
        } else {
            if (!isset($options['action'])) {
                $options['action'] = ["$controller_name@store"];
            }
        }
        if (isset($options['placeholder']) && $options['placeholder'] === true) {
            $this->placeholder = true;
        }
        return $this->form->model($model, $options);
    }

    public function input($type, $name, $label = null, $value = null, $options = array(), $list = array()) {
        $errors = $this->session->get('errors');

        if (is_array($label)) {
            $options = $label;
            $label = null;
        }
        if (is_array($value)) {
            $options = $value;
            $value = null;
        }

        if (!$label) {
            $label = trans("form.$name");
        }

        if ($this->placeholder) {
            $options['placeholder'] = $label;
            $label = null;
        }

        if (isset($options['class'])) {
            $options['class'] .= ' form-control';
        } else {
            $options['class'] = 'form-control';
        }


        $return = '<div class="form-group form-' . $type . ( $errors && $errors->has($name) ? ' has-error' : '' ) . '">';
        if ($label !== false) {
            $return .= $this->form->label($name, $label);
        }
        if ($type == 'textarea') {
            $return .= $this->form->textarea($name, $value, $options);
        } else if ($type == 'select') {
            $return .= $this->form->select($name, $list, $value, $options);
        } else {
            $return .= $this->form->input($type, $name, $value, $options);
        }
        if ($errors && $errors->has($name)){
            $return .= '<p class="help-block">' . $errors->first($name) . '</p>';
        }
        $return .= '</div>';

        return $return;
    }

    public function text($name, $label = null, $value = null, $options = array()) {
        return $this->input('text', $name, $label, $value, $options);
    }

    public function file($name, $label = null, $value = null, $options = array()) {
        return $this->input('file', $name, $label, $value, $options);
    }

    public function email($name, $label = null, $value = null, $options = array()) {
        return $this->input('email', $name, $label, $value, $options);
    }

    public function select($name, $label = null, $value = null, $list = array(), $options = array()) {

        if (is_array($label)) {
            $list = $label;
            $label = null;
        }
        if (is_array($value)) {
            $list = $value;
            $value = null;
        }
        return $this->input('select', $name, $label, $value, $options, $list);
    }

    public function textarea($name, $label = null, $value = null, $options = array()) {
        return $this->input('textarea', $name, $label, $value, $options);
    }

    public function submit($name = null){
        if (!$name) {
            $name = trans('form.submit');
        }
        return '<div class="form-submit"><button type="submit" class="btn btn-primary">' . $name . '</button></div>';
    }

    public function close() {
        return $this->form->close();
    }

}