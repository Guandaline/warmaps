<?php

class vizinhoController extends Controller {

    var $name = 'vizinho';

    public function getVizinho($territorio){
        $this->Model->data['territorio'] = $territorio;
        $res = $this->selectAll();
        $arr = array();
        foreach ($res as $val){
            $arr[$val['id']]['territorio'] = $val['territorio'];
            $arr[$val['id']]['vizinho'] = $val['vizinho'];
        }
        return $arr;
    }


    public function setVizinho($territorio, $vizinho, $valor) {
        $this->Model->data['territorio'] = $territorio;
        $this->Model->data['vizinho'] = $vizinho;
        $id = $this->select('id');
        
        if ($valor) {
            if (empty($id)) {
                $this->save();
            }
        } else {
           if(!empty($id)){
               $id = $id[0];
               $this->delete($id);
           }            
        }
    }

}

?>
