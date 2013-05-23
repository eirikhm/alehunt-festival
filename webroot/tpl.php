<?php
class TemplateGen
{
    public function run()
    {
        $approot = dirname(__FILE__).'/';
        $dir = $approot.'/templates/';
        $templates = $this->scanFolder('',$dir,$dir);


        header("Content-type: application/javascript");

        echo $templates;
        file_put_contents('/tmp/tmpl.js',$templates);
//        exit();
    }

    private function scanFolder($dir,$rootFolder,$baseFolder)
    {
        $templateContents = '';

        $dirContents = scandir($rootFolder.$dir);

        foreach ($dirContents as $entry)
        {
            if ($entry === '.' || $entry === '.svn' ||  $entry === '..' || $entry == 'all.php' || $entry == '_loading.html')
            {
                continue;
            }

            if (is_dir($rootFolder.$entry))
            {
                $rootFolder .= $dir;
                $templateContents .= $this->scanFolder($entry,$rootFolder,$baseFolder);
            }
            else
            {
                $templateContents .= $this->compileTemplate($rootFolder.$dir.DIRECTORY_SEPARATOR.$entry,$baseFolder);
            }
        }
        return $templateContents;
    }

    private function compileTemplate($filename,$baseFolder)
    {

        $templateId = str_replace($baseFolder,'',$filename);
        $templateId = str_replace('/','-',$templateId);
        $templateId = str_replace('.html','',$templateId);
        $command = "dustc -n=$templateId $filename";
        $content = shell_exec($command);
        return $content;
    }


    public function checkAjaxValidationAndEnd($model, $formName)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formName)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

$x = new TemplateGen();
$x->run();