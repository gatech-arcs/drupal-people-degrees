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
        'gt_people_degree_name' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'gt_people_degree_year' => [
          'type' => 'varchar',
          'size' => 10,
        ],
        'gt_people_degree_institution' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'gt_people_degree_location' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'gt_people_degree_designation' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];

    $properties['gt_people_degree_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Degree Name'));

    $properties['gt_people_degree_year'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Year'));

    $properties['gt_people_degree_institution'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Institution'));

    $properties['gt_people_degree_location'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Location'));

    $properties['gt_people_degree_designation'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Designation'))
      ->setDescription(new TranslatableMarkup('Any special designation associated with the degree'));

    return $properties;
  }
  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    // KISS -- consider field empty if the Degree Name is empty.
    $value = $this->get('gt_people_degree_name')->getValue();
    return $value === NULL || $value === '';
  }

}
