<?php

declare(strict_types=1);

namespace Drupal\gtppl_degrees\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Widget for the Degrees compound field.
 */
#[FieldWidget(
  id: 'gtppl_degrees_widget',
  label: new TranslatableMarkup('Degrees widget'),
  field_types: ['gtppl_degrees'],
)]
final class GtpplDegreesWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $item = $items[$delta];

    $default_year = (int) date('Y');
    $settings = $this->getFieldSettings();
    $max_year = $default_year + (int) ($settings['max_year_offset'] ?? 10);

    $element['field_gtppl_degree_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Degree'),
      '#default_value' => $item->get('field_gtppl_degree_name')->getString(),
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $item->get('field_gtppl_degree_year')->getValue() ?? '',
      '#min' => 1950,
      '#max' => $max_year,
      '#step' => 1,
      '#placeholder' => $default_year,
      '#description' => $this->t('Enter the graduation year (YYYY).'),
    ];

    $element['field_gtppl_degree_institution'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Institution'),
      '#default_value' => $item->get('field_gtppl_degree_institution')->getString(),
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Location'),
      '#default_value' => $item->get('field_gtppl_degree_location')->getString(),
      '#maxlength' => 255,
    ];

    $element['field_gtppl_degree_with_honors'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('With honors'),
      '#default_value' => (int) ($item->get('field_gtppl_degree_with_honors')->getValue() ?? 0),
    ];

    $element['field_gtppl_degree_honorary'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Honorary'),
      '#default_value' => (int) ($item->get('field_gtppl_degree_honorary')->getValue() ?? 0),
    ];

    $element['#type'] = 'fieldset';
    $element['#title'] = $this->t('Degree entry');

    return $element;
  }

}
