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
  label: new TranslatableMarkup('Default Degrees Layout'),
  field_types: ['gt_people_degrees'],
)]
class GtPeopleDegreesDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    if (!$items->isEmpty()) {
      foreach ($items as $delta => $item) {
        $elements[$delta] = [
          '#theme' => 'gt_people_degree',
          'name' => $item->name,
          'year' => $item->year,
          'institution' => $item->institution,
          'location' => $item->location,
        ];
      }
    }

    return $elements;
  }

}
