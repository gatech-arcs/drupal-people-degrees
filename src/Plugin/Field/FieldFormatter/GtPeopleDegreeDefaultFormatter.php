<?php

declare(strict_types=1);

namespace Drupal\gt_people_degrees\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Simple formatter for Degrees compound field.
 */
#[FieldFormatter(
  id: 'gt_people_degree_formatter',
  label: new TranslatableMarkup('Default Degree Layout'),
  field_types: ['gt_people_degree'],
)]
class GtPeopleDegreeDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'gt_people_degree',
        '#degree_name' => $item->gt_people_degree_name,
        '#degree_year' => $item->gt_people_degree_year,
        '#degree_institution' => $item->gt_people_degree_institution,
        '#degree_location' => $item->gt_people_degree_location,
        '#degree_designation' => $item->gt_people_degree_designation,
      ];
    }

    return $elements;

  }

}
