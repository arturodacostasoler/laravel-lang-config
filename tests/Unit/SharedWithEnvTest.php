<?php

declare(strict_types=1);

use LaravelLang\Config\Enums\Name;
use LaravelLang\Config\Facades\Config;
use LaravelLang\LocaleList\Locale;

beforeAll(function () {
    putenv('LOCALIZATION_INLINE=true');
    putenv('LOCALIZATION_ALIGN=false');
    putenv('LOCALIZATION_SMART_ENABLED=true');
});

test('inline', function () {
    expect(Config::shared()->inline)
        ->toBeBool()
        ->toBeTrue()
        ->toBe(config('localization.inline'));
});

test('align', function () {
    expect(Config::shared()->align)
        ->toBeBool()
        ->toBeFalse()
        ->toBe(config('localization.align'));
});

test('aliases', function () {
    expect(Config::shared()->aliases->all())
        ->toBeArray()
        ->toBe(config('localization.aliases'));
});

test('smart punctuation: enabled', function () {
    expect(Config::shared()->punctuation->enabled)
        ->toBeBool()
        ->toBeTrue()
        ->toBe(config('localization.smart_punctuation.enable'));
});

test('smart punctuation: common', function () {
    expect(Config::shared()->punctuation->common)
        ->toBeArray()
        ->toBe(config('localization.smart_punctuation.common'));
});

test('smart punctuation: locales', function () {
    expect(Config::shared()->punctuation->locales->all())
        ->toBeArray()
        ->toBe(config('localization.smart_punctuation.locales'));
});

test('smart punctuation: get locale', function () {
    expect(Config::shared()->punctuation->locales->get(Locale::French))
        ->toBeArray()
        ->toBe(config('localization.smart_punctuation.locales.' . Locale::French->value));
});

test('smart punctuation: get default locale', function () {
    expect(Config::shared()->punctuation->locales->get(Locale::Zulu))
        ->toBeArray()
        ->toBe(config('localization.smart_punctuation.common'));
});

test('routes: names', function () {
    expect(Config::shared()->routes->names->parameter)
        ->toBeString()
        ->toBe(config('localization.routes.names.parameter'));

    expect(Config::shared()->routes->names->header)
        ->toBeString()
        ->toBe(config('localization.routes.names.header'));

    expect(Config::shared()->routes->names->cookie)
        ->toBeString()
        ->toBe(config('localization.routes.names.cookie'));

    expect(Config::shared()->routes->names->session)
        ->toBeString()
        ->toBe(config('localization.routes.names.session'));

    expect(Config::shared()->routes->names->column)
        ->toBeString()
        ->toBe(config('localization.routes.names.column'));
});

test('routes: name prefix', function () {
    expect(Config::shared()->routes->namePrefix)
        ->toBeString()
        ->toBe(config('localization.routes.name_prefix'));
});

test('routes: redirect default', function () {
    expect(Config::shared()->routes->redirect)
        ->toBeBool()
        ->toBe(config('localization.routes.redirect_default'));
});

test('models', function () {
    config()->set(Name::Shared() . '.models.suffix', 'qwerty');
    config()->set(Name::Shared() . '.models.helpers', realpath(dirname(__DIR__)));

    expect(Config::shared()->models->suffix)
        ->toBeString()
        ->toBe('qwerty')
        ->toBe(config('localization.models.suffix'));

    expect(Config::shared()->models->helpers)
        ->toBeString()
        ->toBe(realpath(dirname(__DIR__)))
        ->toBe(config('localization.models.helpers'));
});
