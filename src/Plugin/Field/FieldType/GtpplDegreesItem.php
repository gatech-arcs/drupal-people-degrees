<?php

declare(strict_types=1);

namespace Drupal\gtppl_degrees\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Validation\Plugin\Validation\Constraint\ComplexDataConstraint;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Compound "Degrees" field item.
 */
#[FieldType(
  id: 'gtppl_degrees',
  label: new TranslatableMarkup('Degree(s) Information'),
  description: new TranslatableMarkup('Degree name, year, institution, location, with honors, and honorary flags'),
  default_widget: 'gtppl_degrees_widget',
  default_formatter: 'gtppl_degrees_formatter',
)]
final class GtpplDegreesItem extends FieldItemBase {

  /**
   * Instance-level (per bundle) settings defaults.
   */
  public static function defaultFieldSettings(): array {
    return [
      // Default max year = current year + this
      'max_year_offset' => 10,
    ] + parent::defaultFieldSettings();
  }

  /**
   * Field settings form (Manage fields → Edit → Field settings).
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {
    $elements = parent::fieldSettingsForm($form, $form_state);

    $elements['max_year_offset'] = [
      '#type' => 'number',
      '#title' => $this->t('Max year offset'),
      '#default_value' => (int) $this->getSetting('max_year_offset'),
      '#min' => 0,
      '#max' => 200,
      '#step' => 1,
      '#description' => $this->t('Maximum year is "current year + offset".', ['%max' => ((int) date('Y')) + (int) $this->getSetting('max_year_offset')]),
    ];

    return $elements;
  }

  /**
   * Define sub-properties (inner fields).
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];

    $properties['field_gtppl_degree_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Degree'))
      ->setRequired(FALSE);

    // Year stored as integer (validation added in getConstraints()).
    $properties['field_gtppl_degree_year'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Year'))
      ->setRequired(FALSE);

    $properties['field_gtppl_degree_institution'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Institution'))
      ->setRequired(FALSE);

    $properties['field_gtppl_degree_location'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Location'))
      ->setRequired(FALSE);

    $properties['field_gtppl_degree_with_honors'] = DataDefinition::create('boolean')
      ->setLabel(new TranslatableMarkup('With Honors'))
      ->setRequired(FALSE);

    $properties['field_gtppl_degree_honorary'] = DataDefinition::create('boolean')
      ->setLabel(new TranslatableMarkup('Honorary'))
      ->setRequired(FALSE);

    return $properties;
  }

  /**
   * DB schema.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'field_gtppl_degree_name' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ],
        'field_gtppl_degree_year' => [
          'type' => 'int',
          'size' => 'normal',
          'not null' => FALSE,
        ],
        'field_gtppl_degree_institution' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ],
        'field_gtppl_degree_location' => [
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ],
        'field_gtppl_degree_with_honors' => [
          'type' => 'int',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
        'field_gtppl_degree_honorary' => [
          'type' => 'int',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * Runtime, per-instance constraints that can read field settings.
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $current = (int) date('Y');
    $offset = (int) $this->getSetting('max_year_offset');
    $maxYear = $current + $offset;

    $range = new Range([
      'min' => 1950,
      'max' => $maxYear,
      'minMessage' => 'Year must be 1950 or later',
      'maxMessage' => "Year can't be later than {$maxYear}",
    ]);

    // Apply the Range constraint specifically to the sub-property.
    $constraints[] = new ComplexDataConstraint([
      'properties' => [
        'field_gtppl_degree_year' => [$range],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    $name = $this->get('field_gtppl_degree_name')->getString();
    $year = $this->get('field_gtppl_degree_year')->getValue();
    $institution = $this->get('field_gtppl_degree_institution')->getString();
    $location = $this->get('field_gtppl_degree_location')->getString();
    $honors = (int) ($this->get('field_gtppl_degree_with_honors')->getValue() ?? 0);
    $honorary = (int) ($this->get('field_gtppl_degree_honorary')->getValue() ?? 0);

    return $name === '' &&
      (is_null($year) || $year == 0) &&
      $institution === '' &&
      $location === '' &&
      $honors === 0 &&
      $honorary === 0;
  }

}
