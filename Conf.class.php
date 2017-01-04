<?php
class Conf {
    private $file;
    private $xml;
    private $lastmatch;

    function __construct($file){
        $this->file = $file;
        if (!file_exists($file)){
            throw new FileException("���� '$file' �� ������");
        }
        $this->xml = simplexml_load_file($file, null, LIBXML_NOERROR);
        if (!is_object($this->xml)) {
            throw new XmlException(libxml_get_last_error());
        }
        print gettype($this->xml);
        $matches = $this->xml->xpath("/conf");
        if (! count($matches)){
            throw new ConfException("������ �������� conf �� ������");
        }
    }

    function write() {
        if(!is_writable($this->file)){
            throw new FileException("���� {$this->file} ���������� ��� ������.");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }

    function get($str){
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if (count($matches)){
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }
        return null;
    }

    function set($key, $value){
        if (!is_null($this->get($key))){
            $this->lastmatch[0] = $value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item', $value)->addAttribute('name',$key);
    }
}

class XmlException extends Exception{
    private $error;

    function __construct(LibXMLError $error){
        $shortfile = basename($error->file);
        $msg = "[{$shortfile}, ������ {$error->line}, ";
        $msg.= "������� {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }
    function getLibEmlError(){
        return $this->error;
    }
}

class FileException extends Exception{}
class ConfException extends Exception{}

class Runner {
    static function init(){
        try{
            $conf = new Conf("conf/test.xml");
            print "user: ".$conf->get('user')."\n";
            print "host: ".$conf->get('host')."\n";
            $conf->set("pass", "newpas1s");
            $conf->write();
        }catch (FileException $e){
            //���� �� ���������� ���� ��������� ��� ������
        }catch (XmlException $e){
            // ��������� xml
        }catch (ConfException $e){
            // ����������� ������ xml
        }catch (Exception $e){

            // �����������: ���� ��� �� ������ ���������
        }
    }
}
