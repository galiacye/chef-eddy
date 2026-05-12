  <?php 
  
  * @return Controller
      */
     protected function createController()
     {
        assert(is_string($this->controller));
 
         $class = new $this->controller();
         $class->initController($this->request, $this->response, Services::logger());
 
         $this->benchmark->stop('controller_constructor');
 
         return $class;
     }


     // If startController returned a Response (from an attribute or Closure), use it
483         if ($returned instanceof ResponseInterface) {
484             $this->gatherOutput($cacheConfig, $returned);
485         }
486         // Closure controller has run in startController().
487         elseif (! is_callable($this->controller)) {
488             $controller = $this->createController();
489 
490             if (! method_exists($controller, '_remap') && ! is_callable([$controller, $this->method], false)) {
491                 throw PageNotFoundException::forMethodNotFound($this->method);
492             }
493 
494             // Is there a "post_controller_constructor" event?
495             Events::trigger('post_controller_constructor');
