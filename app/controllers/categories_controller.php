<?

    /**
     * @property Category $Category
     */
    class CategoriesController extends AppController {

        function admin_index() {
            $categorylist=$this->Category->generatetreelist(null, null, null, "&nbsp;&nbsp;&nbsp;&nbsp;");
            $this->set(compact('categorylist'));
        }

        function admin_add() {
            if (!empty($this->data)) {

                $this->Category->save($this->data);
                $this->redirect(array('action' => 'index'));
            } else {
                $parents[0]="[ No Parent ]";
                $categorylist=$this->Category->generatetreelist(null, null, null, " - ");
                if ($categorylist)
                    foreach ($categorylist as $key => $value)
                        $parents[$key]=$value;
                $this->set(compact('parents'));
            }
        }

        function admin_edit($id=null) {
            if (!empty($this->data)) {
                if ($this->Category->save($this->data) == false)
                    $this->Session->setFlash('Error saving Category.');
                $this->redirect(array('action' => 'index'));
            } else {
                if ($id == null)
                    die("No ID received");
                $this->data=$this->Category->read(null, $id);
                $parents[0]="[ No Parent ]";
                $categorylist=$this->Category->generatetreelist(null, null, null, " - ");
                if ($categorylist)
                    foreach ($categorylist as $key => $value)
                        $parents[$key]=$value;
                $this->set(compact('parents'));
            }
        }

        function admin_delete($id=null) {
            if ($id == null)
                die("No ID received");
            $this->Category->id=$id;
            if ($this->Category->delete() == false)
                $this->Session->setFlash('The Category could not be deleted.');
            $this->redirect(array('action' => 'index'));
        }

        function admin_moveup($id=null) {
            if ($id == null)
                die("No ID received");
            $this->Category->id=$id;
            if ($this->Category->moveup() == false)
                $this->Session->setFlash('The Category could not be moved up.');
            $this->redirect(array('action' => 'index'));
        }

        function admin_movedown($id=null) {
            if ($id == null)
                die("No ID received");
            $this->Category->id=$id;
            if ($this->Category->movedown() == false)
                $this->Session->setFlash('The Category could not be moved down.');
            $this->redirect(array('action' => 'index'));
        }

    }

