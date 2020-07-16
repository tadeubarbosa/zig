<?php

namespace System\View;

use App\HtmlComponents\Modal;

class View
{
  private $viewName;
  private $layoutName;
  private $withLayout;
  public $pathToView;
  public $title;
  public $data = [];

  public function getData()
  {
    return $this->data;
  }

  public function view(String $viewName, $withLayout = false, $data = false)
  {
    if ($data) {
      # Set in array the values passed to view
      foreach ($data as $key => $itens) {
        $this->data[$key] = $itens;
      }
    }

    # Set the view Name
    $this->viewName = $viewName;
    $this->withLayout = $withLayout;
    return $this;
  }

  /**
   * Execute ao encerrar a classe
   */
  public function __destruct()
  {
    # se não houverem views, não executa
    if ($this->viewName == null) {
      return;
    }
    # Full path to View
    $fullPathToView = __DIR__ . "/../../App/Views/{$this->viewName}.php";

    try {
      if (file_exists($fullPathToView)) {

        $this->pathToView = $fullPathToView;

        if ($this->withLayout) {
          $this->layout($this->withLayout);
        } else {
          $this->viewRender();
        }
      } else {
        throw new \Exception("A view (" . $this->viewName . ") Não existe!");
      }
    } catch (\Exception $e) {
      createMessage($e);
    }
  }

  /**
   * This method is used to set the view name
   * @return Void
   */
  public function layout($layoutName)
  {
    $this->layoutName = $layoutName;

    # Full path to Layout
    $fullPathToLayout = __DIR__ . "/../../App/Views/Layouts/{$this->layoutName}.php";

    try {
      if (file_exists($fullPathToLayout)) {
        require_once($fullPathToLayout);
      } else {
        throw new \Exception("O Layout (" . $this->layoutName . ") Não existe!");
      }
    } catch (\Exception $e) {
      createMessage($e);
    }
  }

  public function title($title)
  {
    $this->title = $title;
    return $this;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function viewRender()
  {
    # Passing the values to be used into the views
    foreach ($this->getData() as $key => $itens) {
      $$key = $itens;
    }

    require_once($this->pathToView);
  }
}
