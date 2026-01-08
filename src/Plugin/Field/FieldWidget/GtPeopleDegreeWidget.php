<?php

declare(strict_types=1);

namespace Drupal\gt_people_degrees\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Widget for the Degrees compound field.
 * https://www.drupal.org/docs/creating-custom-modules/creating-custom-field-types-widgets-and-formatters/create-a-custom-field-widget
 */
#[FieldWidget(
  id: 'gt_people_degree_widget',
  label: new TranslatableMarkup('Degrees Form'),
  field_types: ['gt_people_degree'],
)]
class GtPeopleDegreeWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element += [
      '#type' => 'fieldset',
      '#title' => $this->t('Degree @delta', ['@delta' => $delta + 1]),
      '#open' => TRUE,
    ];

    $element['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Degree'),
      '#default_value' => $items[$delta]->name ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['year'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Year'),
      '#default_value' => $items[$delta]->year ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['institution'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Institution'),
      '#default_value' => $items[$delta]->institution ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Location'),
      '#default_value' => $items[$delta]->location ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    return $element;
  }
}
