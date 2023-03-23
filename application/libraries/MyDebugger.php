<?php
class MyDebugger {
    public function x()
    {
        // Mostra onde o x foi chamado
        // $arLocal = array_shift(debug_backtrace());
        $trace = debug_backtrace();
        while ($arLocal = array_shift($trace)) {
            if (preg_match('/(MyDebugger|eval\(\))+/', $arLocal['file'])) {
                $arLocal = array_shift($trace);
                continue;
            }
            break;
        }
        $stLocal = 'Arquivo :' . $arLocal['file'] . ' ---> Linha ' . $arLocal['line'];


        echo "
        <style>
            .pre-scrollable {
                max-height: 600px;
            }
        </style>
        <div style='display:none'>on line 0</div>
		<div class=\"container-fluid\">
        <div class=\"page-header \">
          <h1>" . __FUNCTION__ . "</h1> <small>{$stLocal}</small>
        </div> ";
        if (count(func_get_args())) {
            $class = func_num_args() > 1 ? 'pre-scrollable' : '';
            foreach (func_get_args() as $idx => $arg) {
                echo '
            <div class="panel panel-warning">
                <div class="panel-heading"><strong>ARG[' . $idx . ']</strong></div>
                <div class="panel-body">
                <pre class="' . $class . '">' . print_r($arg, true) . '</pre>
                </div>
            </div>';
            }
        } else {
            echo "Sem argumentos!";
        }
        echo "</div>";
        flush();
    }

    public static function xd()
    {
        // Mostra onde o x foi chamado
        // $arLocal = array_shift(debug_backtrace());
        $trace = debug_backtrace();
        while ($arLocal = array_shift($trace)) {
            if (preg_match('/(MyDebugger|eval\(\))+/', $arLocal['file'])) {
                $arLocal = array_shift($trace);
                continue;
            }
            break;
        }
        $stLocal = 'Arquivo :' . $arLocal['file'] . ' ---> Linha ' . $arLocal['line'];
        echo "
        <style>
            .pre-scrollable {
                max-height: 600px;
            }
        </style>
        <div style='display:none'>on line 0</div>
		<div class=\"container-fluid\">
        <div class=\"page-header \">
          <h1>" . __FUNCTION__ . "</h1> <small>{$stLocal}</small>
        </div> ";
        if (count(func_get_args())) {
            $class = func_num_args() > 1 ? 'pre-scrollable' : '';
            foreach (func_get_args() as $idx => $arg) {
                echo '
            <div class="panel panel-info">
                <div class="panel-heading"><strong>ARG[' . $idx . ']</strong></div>
                <div class="panel-body">
                <pre class="' . $class . '">' . print_r($arg, true) . '</pre>
                </div>
            </div>';
            }
        } else {
            echo "Sem argumentos!";
        }
        echo "</div>";
        flush();
        die();
    }
}