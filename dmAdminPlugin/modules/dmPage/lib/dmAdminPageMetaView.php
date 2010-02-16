<?php

class dmAdminPageMetaView
{
  protected
  $helper,
  $i18n,
  $page,
  $availableFields = array(
    'name' => 'Name',
    'slug' => 'Url',
    'title' => 'Title',
    'h1' => 'H1',
    'description' => 'Description',
    'is_active' => 'Available',
    'lft' => 'Position'
  );

  public function __construct(dmHelper $helper, dmI18n $i18n)
  {
    $this->helper = $helper;
    $this->i18n   = $i18n;

    $this->initialize();
  }

  protected function initialize()
  {
    $this->clickToEditText = $this->i18n->__('Click to edit');
  }

  public function setPage($page)
  {
    $this->page = $page;
  }

  public function getAvailableFields()
  {
    return $this->availableFields();
  }

  public function renderField($field)
  {
    return $this->i18n->__($this->availableFields[$field]);
  }

  public function renderMeta($field)
  {
    if('is_active' === $field)
    {
      $html = $this->renderBooleanMeta($field);
    }
    else
    {
      $html = $this->renderStringMeta($field);
    }

    return $html;
  }

  public function renderStringMeta($field)
  {
    $value = $this->page[$field];
    
    if('lft' === $field)
    {
      return sprintf(
        '<td><span style="margin-left: %dpx;" class="s16block s16_page_%s">%s</span></td>',
        $this->page['level'] * 15,
        'show' === $this->page['action'] ? 'auto' : 'manual',
        $this->page[$field]
      );
    }
    elseif('slug' === $field && 1 == $this->page['lft'])
    {
      return '<td>/</td>';
    }
    
    $editType = in_array($field, array('description', 'keywords')) ? 'edit_textarea' : 'edit_input';
    
    return sprintf(
      '<td class="editable %s" rel="%s" title="%s">%s</td>',
      $editType,
      $field,
      $this->clickToEditText,
      $this->page[$field]
    );
  }

  public function renderBooleanMeta($field)
  {
    return sprintf(
      '<td class="boolean" rel="%s" title="%s">%s</td>',
      $field,
      $this->clickToEditText,
      $this->page[$field]
    );
  }
}