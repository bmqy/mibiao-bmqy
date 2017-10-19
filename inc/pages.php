<?php
global $cp;
$cp = !empty($_GET['cp']) ? $_GET['cp'] : 1;

class pages{
    private $rs,$totalPage,$cp,$pageSize,$pageCount,$urlParameter;

    public function __construct($rs, $pageSize, $urlParameter){
        global $cp;
        $this->rs = $rs;
        $this->cp = $cp;
        $this->pageSize = $pageSize ? $pageSize : PagesSize;
        $this->pageCount = PagesCount;
        $this->totalPage = ceil($rs->num_rows / $this->pageSize);
        $this->urlParameter = $urlParameter;
    }

    public function getPages(){
        if(empty($this->urlParameter)){
            $this->urlParameter = '';
        }
        else{
            $this->urlParameter = $this->urlParameter .'&';
        }

        if($this->cp <= 1){
            $this->cp = 1;
            echo '<li class="disabled"><a href="#" title="首页" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        else{
            echo '<li><a href="/" title="首页" aria-label="Home"><span aria-hidden="true">&laquo;</span></a></li>';
            echo '<li><a href="?'. $this->urlParameter .'cp='. ($this->cp - 1) .'" title="上一页" aria-label="Previous"><span aria-hidden="true">&lt;</span></a></li>';
        }
        if($this->totalPage - $this->cp >= $this->pageCount){
            $this->pageCount = $this->cp + $this->pageCount-1;
        }
        else{
            $this->pageCount = $this->cp + ($this->totalPage - $this->cp);
        }
        for($i=$this->cp;$i<=$this->pageCount;$i++ ){
            if($i==$this->cp){
                echo '<li class="active"><a href="javascript:;">'. $i .'<span class="sr-only">(current)</span></span></a></li>';
            }
            else{
                echo '<li><a href="?'. $this->urlParameter .'cp='. $i .'" aria-label="Previous"><span aria-hidden="true">'. $i .'</span></a></li>';
            }
        }
        if($this->cp >= $this->totalPage){
            echo '<li class="disabled"><a href="#" title="最后一页" aria-label="End"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        else{
            echo '<li><a href="?'. $this->urlParameter .'cp='. ($this->cp + 1) .'" title="下一页" aria-label="Next"><span aria-hidden="true">&gt;</span></a></li>';
            echo '<li><a href="?'. $this->urlParameter .'cp='. $this->totalPage .'" title="尾页" aria-label="End"><span aria-hidden="true">&raquo;</span></a></li>';
        }
    }
}
?>