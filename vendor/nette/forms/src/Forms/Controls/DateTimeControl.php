<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\Forms\Controls;

use Nette;
use Nette\Forms\Form;


/**
 * Selects date or time or date & time.
 */
class DateTimeControl extends BaseControl
{
	public const
		TypeDate = 1,
		TypeTime = 2,
		TypeDateTime = 3;

	public const
		FormatObject = 'object',
		FormatTimestamp = 'timestamp';

	/** @var int */
	private $type;

	/** @var bool  */
	private $withSeconds;

	/** @var string */
	private $format = self::FormatObject;


	public function __construct($label = null, int $type = self::TypeDate, bool $withSeconds = false)
	{
		$this->type = $type;
		$this->withSeconds = $withSeconds;
		parent::__construct($label);
		$this->control->step = $withSeconds ? 1 : null;
	}


	public function getType(): int
	{
		return $this->type;
	}


	/**
	 * Format of returned value. Allowed values are string (ie 'Y-m-d'), DateTimeControl::FormatObject and DateTimeControl::FormatTimestamp.
	 * @return static
	 */
	public function setFormat(string $format)
	{
		$this->format = $format;
		return $this;
	}


	/**
	 * @param \DateTimeInterface|string|int|null $value
	 * @return static
	 */
	public function setValue($value)
	{
		$this->value = $value === null ? null : $this->normalizeValue($value);
		return $this;
	}


	/**
	 * @return \DateTimeImmutable|string|int|null
	 */
	public function getValue()
	{
		if ($this->format === self::FormatObject) {
			return $this->value;
		} elseif ($this->format === self::FormatTimestamp) {
			return $this->value ? $this->value->getTimestamp() : null;
		} else {
			return $this->value ? $this->value->format($this->format) : null;
		}
	}


	/**
	 * @param \DateTimeInterface|string|int $value
	 */
	private function normalizeValue($value): \DateTimeImmutable
	{
		if (is_numeric($value)) {
			$dt = (new \DateTimeImmutable)->setTimestamp((int) $value);
		} elseif (is_string($value)) {
			$dt = new \DateTimeImmutable($value); // createFromFormat() must not be used because it allows invalid values
		} elseif ($value instanceof \DateTime) {
			$dt = \DateTimeImmutable::createFromMutable($value);
		} elseif ($value instanceof \DateTimeImmutable) {
			$dt = $value;
		} elseif (!$value instanceof \DateTimeInterface) {
			throw new Nette\InvalidArgumentException('Value must be DateTimeInterface or string or null, ' . gettype($value) . ' given.');
		}

		[$h, $m, $s] = [(int) $dt->format('H'), (int) $dt->format('i'), $this->withSeconds ? (int) $dt->format('s') : 0];
		if ($this->type === self::TypeDate) {
			return $dt->setTime(0, 0);
		} elseif ($this->type === self::TypeTime) {
			return $dt->setDate(0, 1, 1)->setTime($h, $m, $s);
		} elseif ($this->type === self::TypeDateTime) {
			return $dt->setTime($h, $m, $s);
		}
	}


	public function loadHttpData(): void
	{
		$value = $this->getHttpData(Nette\Forms\Form::DataText);
		try {
			$this->value = is_string($value) && preg_match('~^(\d{4}-\d{2}-\d{2})?T?(\d{2}:\d{2}(:\d{2}(\.\d+)?)?)?$~', $value)
				? $this->normalizeValue($value)
				: null;
		} catch (\Throwable $e) {
			$this->value = null;
		}
	}


	public function getControl(): Nette\Utils\Html
	{
		return parent::getControl()->addAttributes([
			'value' => $this->value ? $this->formatHtmlValue($this->value) : null,
			'type' => [self::TypeDate => 'date', self::TypeTime => 'time', self::TypeDateTime => 'datetime-local'][$this->type],
		]);
	}


	/**
	 * Formats a date/time for HTML attributes.
	 * @param  \DateTimeInterface|string|int  $value
	 */
	public function formatHtmlValue($value): string
	{
		$value = $this->normalizeValue($value);
		return $value->format([
			self::TypeDate => 'Y-m-d',
			self::TypeTime => $this->withSeconds ? 'H:i:s' : 'H:i',
			self::TypeDateTime => $this->withSeconds ? 'Y-m-d\\TH:i:s' : 'Y-m-d\\TH:i',
		][$this->type]);
	}


	/**
	 * Formats a date/time according to the locale and formatting options.
	 * @param  \DateTimeInterface|string|int  $value
	 */
	public function formatLocaleText($value): string
	{
		$value = $this->normalizeValue($value);
		if ($this->type === self::TypeDate) {
			return \IntlDateFormatter::formatObject($value, [\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE]);
		} elseif ($this->type === self::TypeTime) {
			return \IntlDateFormatter::formatObject($value, [\IntlDateFormatter::NONE, $this->withSeconds ? \IntlDateFormatter::MEDIUM : \IntlDateFormatter::SHORT]);
		} elseif ($this->type === self::TypeDateTime) {
			return \IntlDateFormatter::formatObject($value, [\IntlDateFormatter::MEDIUM, $this->withSeconds ? \IntlDateFormatter::MEDIUM : \IntlDateFormatter::SHORT]);
		}
	}


	/** @return static */
	public function addRule($validator, $errorMessage = null, $arg = null)
	{
		if ($validator === Form::Min) {
			$this->control->min = $arg = $this->formatHtmlValue($arg);
		} elseif ($validator === Form::Max) {
			$this->control->max = $arg = $this->formatHtmlValue($arg);
		} elseif ($validator === Form::Range) {
			$this->control->min = isset($arg[0])
				? $arg[0] = $this->formatHtmlValue($arg[0])
				: null;
			$this->control->max = isset($arg[1])
				? $arg[1] = $this->formatHtmlValue($arg[1])
				: null;
		}

		return parent::addRule($validator, $errorMessage, $arg);
	}
}
