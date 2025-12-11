<?php

declare(strict_types=1);

namespace Drupal\gtppl_degrees\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Simple formatter for Degrees compound field.
 */
#[FieldFormatter(
  id: 'gtppl_degrees_formatter',
  label: new TranslatableMarkup('Degrees'),
  field_types: ['gtppl_degrees'],
)]
final class GtpplDegreesFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    foreach ($items as $delta => $item) {
      $degree = $item->get('field_gtppl_degree_name')->getString();
      $year = $item->get('field_gtppl_degree_year')->getValue();
      $institution = $item->get('field_gtppl_degree_institution')->getString();
      $location = $item->get('field_gtppl_degree_location')->getString();
      $honors = (int) ($item->get('field_gtppl_degree_with_honors')->getValue() ?? 0);
      $honorary = (int) ($item->get('field_gtppl_degree_honorary')->getValue() ?? 0);

      $bits = array_filter([
        $degree ?: NULL,
        $year ? (string) $year : NULL,
        $institution ?: NULL,
        $location ?: NULL,
        $honors ? $this->t('with honors') : NULL,
        $honorary ? $this->t('honorary') : NULL,
      ]);

      $elements[$delta] = [
        '#type' => 'inline_template',
        '#template' => '{{ content|safe_join(", ") }}',
        '#context' => [
          'content' => $bits,
        ],
      ];
    }

    return $elements;
  }

}
