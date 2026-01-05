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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

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
      '#type' => 'datelist',
      '#title' => $this->t('Year'),
      '#default_value' => isset($items[$delta]->year)
          ? \Drupal::service('date.formatter')->format(strtotime($items[$delta]->year . '-01-01'), 'custom', 'Y')
          : NULL,
      '#date_part_order' => ['year'],
      '#date_year_range' => '1950:2050',
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

    $element['gt_people_degree_designation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Designation'),
      '#default_value' => $items[$delta]->designation ?? NULL,
      '#description' => $this->t('Any special designation associated with the degree, e.g. "with Honors"'),
      '#size' => 60,
      '#maxlength' => 255,
    ];

    return $element;
  }

}
