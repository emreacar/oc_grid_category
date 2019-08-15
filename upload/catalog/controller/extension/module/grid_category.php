<?php
class ControllerExtensionModuleGridCategory extends Controller {
	public function index($data) {
        $this->document->addStyle('catalog/view/theme/default/stylesheet/grid_category.css');
        $this->load->model('catalog/category');
        $category_ids = [];

        forEach($data['config'] as $rowKey => $row) {

            foreach($row['columns'] as $colKey => $col) {
                
                if($col['type'] == 'category') {
                    $categories = array_keys($col['categories']);

                    foreach($categories as $category_id) {

                        $catData = $this->model_catalog_category->getCategory($category_id);
                        
                        $data['config'][$rowKey]['columns'][$colKey]['categories'][$category_id]['image'] = $catData['image'];
                        if($catData['parent_id'] == 0) {
                            $data['config'][$rowKey]['columns'][$colKey]['categories'][$category_id]['href'] = $this->url->link('product/category', 'path=' . $catData['category_id']);
                        }else{
                            $data['config'][$rowKey]['columns'][$colKey]['categories'][$category_id]['href'] = $this->url->link('product/category', 'path=' . $catData['parent_id'].'_'.$catData['category_id']);
                        }

                    }
                }else{

                    foreach($col['rows'] as $subRowKey => $subRow) {

                        foreach($subRow['columns'] as $subColKey => $subCol) {

                            $categories = array_keys($subCol['categories']);

                                foreach($categories as $category_id) {

                                    $catData = $this->model_catalog_category->getCategory($category_id);
                                   
                                    $data['config'][$rowKey]['columns'][$colKey]['rows'][$subRowKey]['columns'][$subColKey]['categories'][$category_id]['image'] = $catData['image'];
                                    if($catData['parent_id'] == 0) {
                                        $data['config'][$rowKey]['columns'][$colKey]['rows'][$subRowKey]['columns'][$subColKey]['categories'][$category_id]['href'] = $this->url->link('product/category', 'path=' . $catData['category_id']);
                                    }else{
                                        $data['config'][$rowKey]['columns'][$colKey]['rows'][$subRowKey]['columns'][$subColKey]['categories'][$category_id]['href'] = $this->url->link('product/category', 'path=' . $catData['parent_id'].'_'.$catData['category_id']);
                                    }
                                }

                        }

                    }

                }
                
            }
        }

		return $this->load->view('extension/module/grid_category', $data);
	}
}