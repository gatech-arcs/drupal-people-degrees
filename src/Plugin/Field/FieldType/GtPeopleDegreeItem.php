<?php

declare(strict_types=1);

namespace Drupal\gt_people_degrees\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Compound "Degrees" field item.
 */
#[FieldType(
  id: 'gt_people_degree',
  label: new TranslatableMarkup('Degree Listing'),
  description: new TranslatableMarkup('Degree name, year, institution, location, and any designation.'),
  default_widget: 'gt_people_degree_widget',
  default_formatter: 'gt_people_degree_formatter',
)]
class GtPeopleDegreeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'name' => ['type' => 'varchar', 'length' => 255],
        'year' => ['type' => 'varchar', 'length' => 255],
        'institution' => ['type' => 'varchar', 'length' => 255],
        'location' => ['type' => 'varchar', 'length' => 255],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];

    $properties['name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Degree Name'))
      ->setDescription(new TranslatableMarkup('Full level, field, any designation e.g. BS with Honors Chemistry '));

    $properties['year'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Year'));

    $properties['institution'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Institution'));

    $properties['location'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Location'));

    return $properties;
  }
  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->get('name')->getValue() === NULL
      && $this->get('year')->getValue() === NULL
      && $this->get('institution')->getValue() === NULL
      && $this->get('location')->getValue() === NULL;
  }

}
