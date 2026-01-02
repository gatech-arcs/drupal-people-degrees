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
    $item = $items[$delta];

    $default_year = (int) date('Y');
    $settings = $this->getFieldSettings();
    $max_year = $default_year + 10;

    $element += [
      '#type' => 'fieldset',
      '#title' => $this->t('Degree @delta', ['@delta' => $delta + 1]),
      '#open' => TRUE,
    ];

    $element['field_gtppl_degree_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Degree'),
      '#default_value' => $items[$delta]->field_gtppl_degree_name ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_year'] = [
      '#type' => 'datelist',
      '#title' => $this->t('Year'),
      '#default_value' => isset($items[$delta]->field_gtppl_degree_year)
          ? \Drupal::service('date.formatter')->format(strtotime($items[$delta]->field_gtppl_degree_year . '-01-01'), 'custom', 'Y')
          : NULL,
      '#date_part_order' => ['year'],
      '#date_year_range' => '1950:2050',
    ];

    $element['field_gtppl_degree_institution'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Institution'),
      '#default_value' => $items[$delta]->field_gtppl_degree_institution ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Location'),
      '#default_value' => $items[$delta]->field_gtppl_degree_location ?? NULL,
      '#size' => 60,
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_designation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Designation'),
      '#default_value' => $items[$delta]->field_gtppl_degree_designation ?? NULL,
      '#description' => $this->t('Any special designation associated with the degree, e.g. "with Honors"'),
      '#size' => 60,
      '#maxlength' => 255,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state): array {
    // The datelist returns an array or object, so need to flatten it to a year string
    foreach ($values as &$item) {
      if (isset($item['field_gtppl_degree_year']) && is_array($item['field_gtppl_degree_year'])) {
        // Extract the year from the datelist array (usually keyed by 'year').
        $year = $item['field_gtppl_degree_year']['year'] ?? NULL;
        $item['field_gtppl_degree_year'] = $year;
      } elseif ($item['field_gtppl_degree_year'] instanceof \Drupal\Core\Datetime\DrupalDateTime) {
        $item['field_gtppl_degree_year'] = $item['field_gtppl_degree_year']->format('Y');
      }
    }

    return parent::massageFormValues($values, $form, $form_state);
  }

}
