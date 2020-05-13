<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function safe($str)
{
    return strip_tags(trim($str));
}

function read_json($path)
{
    $string = file_get_contents($path);
    $obj = json_decode($string);
    return $obj;
}

function generate_crud($string, $path)
{
    $create = fopen($path, "w") or die("Unable to open file!");
    fwrite($create, $string);
    fclose($create);
    return $path;
}

function delete_recursive($path)
{
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? delete_recursive($file) : unlink($file);
    }
    rmdir($path);
}

function label($str)
{
    $label = str_replace('_', ' ', $str);
    $label = ucwords($label);
    return $label;
}

function flash_msg($content = '', $type = '')
{
    if ($type == 'success') {
        $icon = 'check-circle';
        $title = 'Success';
        $class = 'success';
    } elseif ($type == 'error') {
        $icon = 'times-circle';
        $title = 'Failed';
        $class = 'danger';
    } elseif ($type == 'warning') {
        $icon = 'exclamation-triangle';
        $title = 'Warning';
        $class = 'warning';
    } else {
        $icon = 'question-circle';
        $title = 'Info';
        $class = 'info';
    }

    if ($content != '') {
        return '
        <div id="alert-message">
        <div class="alert alert-' . $class . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            <h5><i class="icon fa fa-' . $icon . '"></i> ' . ucfirst($title) . '!</h5>
            ' . $content . '
        </div>
        </div>
        ';
    }
}

function warning_msg($content = '', $type = 'warning')
{
    if ($content != '') {
        return '
        <div id="alert-message">
        <div class="alert alert-' . $type . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> ' . ucfirst($type) . '!</h5>
            ' . $content . '
        </div>
        </div>
        ';
    }
}

function success_msg($content = '', $type = 'success')
{
    if ($content != '') {
        return '
        <div id="alert-message">
        <div class="alert alert-' . $type . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            <h5><i class="icon fas fa-check-circle"></i> ' . ucfirst($type) . '!</h5>
            ' . $content . '
        </div>
        </div>
        ';
    }
}

function error_msg($content = '', $type = 'danger')
{
    if ($content != '') {
        return '
        <div id="alert-message">
        <div class="alert alert-' . $type . ' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
            <h5><i class="icon fas fa-check-circle"></i> ' . ucfirst($type) . '!</h5>
            ' . $content . '
        </div>
        </div>
        ';
    }
}

// Modal Content
function modal($content = '', $id = '', $data = '', $size = '')
{
    $_ci = &get_instance();

    if ($content != '') {
        $view_content = $_ci->load->view($content, $data, TRUE);
        return '
    <div class="modal fade" id="' . $id . '" role="dialog">
        <div class="modal-dialog modal-' . $size . '" role="document">
            <div class="modal-content">
            ' . $view_content . '
            </div>
        </div>
    </div>
    ';
    }
}

// Modal Confirm Delete
function confirm($url = '', $id = '', $title = '', $body = '', $subbody = '')
{
    if (!empty($id)) {
        echo '
    <div class="modal fade show" id="' . $id . '" role="dialog">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center"><i class="fa fa-warning mr-2" style="color:#dd4b39"></i>' . $title . '</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5><b>' . $body . '</b></h5>
                    <p>' . $subbody . '</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="' . $url . '" type="button" class="btn btn-danger"><i class="fa fa-check-circle mr-1"></i> Yes</a>
                    <button class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times-circle mr-1"></i> No</button>
                </div> <!-- /.modal footer -->
            </div> <!-- /.modal content-->
        </div> <!-- /.modal dialog-->

    </div> <!-- /.modal -->
    ';
    }
}

function confirm_submit($id = '', $title = '', $body = '', $subbody = '')
{
    if (!empty($id)) {
        echo '
    <div class="modal fade show" id="' . $id . '" role="dialog">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center"><i class="fa fa-warning mr-2" style="color:#dd4b39"></i>' . $title . '</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5><b>' . $body . '</b></h5>
                    <p>' . $subbody . '</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check-circle mr-1"></i> Yes</button>
                    <button class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times-circle mr-1"></i> No</button>
                </div>
            </div> <!-- /.modal content-->
        </div> <!-- /.modal dialog-->

    </div> <!-- /.modal -->
    ';
    }
}

function email_send($mail_to, $subject, $content)
{
    $_ci = &get_instance();
    $mail_from  = $_ci->config->item('mail_username');
    $from_name  = "CIA-HMVC System";
    $crlf =  $_ci->config->item('crlf');
    $charset =  $_ci->config->item('charset');

    $sub_content = "
    <p>Sincerely Yours,<br>
    <b>Administrator</b></p>
    ";

    $email_content =
        "<table cellpadding='0' cellspacing='0' align='center' style='border: 1px solid #d9d9d9'>
        <tr>
            <td>
                <table align='center' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse'>
                    <tr>
                        <td align='center' style='padding: 5px 0; border-bottom: 1px solid #d9d9d9'>
                            <img src='https://stikom.binaniaga.web.id/assets/img/stikom-bn.png' alt='CIA HMVC' style='display: block' height='80px' />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' style='padding: 30px 20px;'>
                            <center>" . $content . "</center>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' style='padding: 10px 13%;'>
                        " . $sub_content . "
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#737f8c' style='padding: 5px 0'>
                            <center>
                                <font color='#ffffff'>CIA-HMVC &copy; " . date("Y") . "</font>
                            </center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </table>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . $crlf;
    $headers .= "Content-type:text/html;" . $charset . $crlf;

    // More headers
    $headers .= 'From: ' . $from_name . $crlf;
    $headers .= 'Cc: ' . $mail_from . $crlf;

    mail($mail_to, $subject, $email_content, $headers);
}

function mail_template($mail_content)
{
    "<table border='1' cellpadding='0' cellspacing='0' align='center'>
        <tr>
            <td>
                <table align='center' border='1' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;'>
                    <tr>
                        <td align='center' style='padding: 20px 0 10px 0;'>
                            <img src='" . base_url('assets/dist/img/stikom-bn.png') . "' alt='My Company' style='display: block;' height='80px' />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#bec4ca' style='padding: 30px 30px 40px 30px;'>
                            " . $mail_content . "
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#0099ff' style='padding: 5px 0 5px 0;'>
                            <center>
                                <font color='#fff'>CIA-HMVC &copy; " . date("Y") . "</font>
                            </center>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>";
}
