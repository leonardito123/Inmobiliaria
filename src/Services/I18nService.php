<?php

namespace App\Services;

use App\Core\Env;

/**
 * I18n Service — Internacionalización ES-MX · ES-CO · ES-CL
 *
 * Estrategia propia PHP/JS sin librerías externas.
 * Las traducciones se cargan desde arrays PHP y se exponen al
 * frontend como objeto JSON en el layout.
 */
class I18nService
{
    /** @var array<string, array<string, string>> */
    private static array $translations = [];

    /** @var string */
    private string $locale;

    public function __construct(string $countryCode = 'MX')
    {
        $this->locale = match (strtoupper($countryCode)) {
            'CO'    => 'es-CO',
            'CL'    => 'es-CL',
            default => 'es-MX',
        };

        if (empty(self::$translations)) {
            self::$translations = self::loadTranslations();
        }
    }

    /**
     * Obtiene un string traducido al locale actual.
     */
    public function t(string $key, array $replace = []): string
    {
        $text = self::$translations[$this->locale][$key]
            ?? self::$translations['es-MX'][$key]
            ?? $key;

        foreach ($replace as $placeholder => $value) {
            $text = str_replace(':' . $placeholder, $value, $text);
        }

        return $text;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Serializa las traducciones del locale actual como JSON para el frontend.
     */
    public function toJson(): string
    {
        $data = self::$translations[$this->locale]
            ?? self::$translations['es-MX']
            ?? [];

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    // -------------------------------------------------------------------------
    // Traducciones estáticas
    // -------------------------------------------------------------------------

    /** @return array<string, array<string, string>> */
    private static function loadTranslations(): array
    {
        return [
            'es-MX' => [
                // Nav
                'nav.home'        => 'Inicio',
                'nav.venta'       => 'Venta',
                'nav.renta'       => 'Renta',
                'nav.desarrollos' => 'Desarrollos',
                'nav.contacto'    => 'Contacto',

                // Moneda / precios
                'price.prefix'    => '$',
                'price.currency'  => 'MXN',
                'price.label'     => 'Precio en pesos mexicanos',

                // Propiedades
                'prop.bedrooms'   => 'Recámaras',
                'prop.bathrooms'  => 'Baños',
                'prop.sqm'        => 'm²',
                'prop.available'  => 'Disponible',
                'prop.reserved'   => 'Reservada',
                'prop.sold'       => 'Vendida',

                // Formularios
                'form.name'       => 'Tu nombre',
                'form.email'      => 'Correo electrónico',
                'form.phone'      => 'Teléfono celular',
                'form.message'    => 'Tu mensaje',
                'form.send'       => 'Enviar',
                'form.required'   => 'Campo obligatorio',

                // CTA
                'cta.contact'     => 'Agendar visita',
                'cta.viewMore'    => 'Ver más propiedades',
                'cta.calculate'   => 'Calcular hipoteca',

                // País
                'country.label'   => 'México',
                'country.phone'   => '+52 55',
            ],

            'es-CO' => [
                'nav.home'        => 'Inicio',
                'nav.venta'       => 'Compra',
                'nav.renta'       => 'Arriendo',
                'nav.desarrollos' => 'Proyectos',
                'nav.contacto'    => 'Contáctenos',

                'price.prefix'    => '$',
                'price.currency'  => 'COP',
                'price.label'     => 'Precio en pesos colombianos',

                'prop.bedrooms'   => 'Habitaciones',
                'prop.bathrooms'  => 'Baños',
                'prop.sqm'        => 'm²',
                'prop.available'  => 'Disponible',
                'prop.reserved'   => 'Apartada',
                'prop.sold'       => 'Vendida',

                'form.name'       => 'Tu nombre',
                'form.email'      => 'Correo electrónico',
                'form.phone'      => 'Celular',
                'form.message'    => 'Tu consulta',
                'form.send'       => 'Enviar',
                'form.required'   => 'Campo obligatorio',

                'cta.contact'     => 'Solicitar visita',
                'cta.viewMore'    => 'Ver más inmuebles',
                'cta.calculate'   => 'Simular crédito',

                'country.label'   => 'Colombia',
                'country.phone'   => '+57 1',
            ],

            'es-CL' => [
                'nav.home'        => 'Inicio',
                'nav.venta'       => 'Venta',
                'nav.renta'       => 'Arriendo',
                'nav.desarrollos' => 'Proyectos',
                'nav.contacto'    => 'Contacto',

                'price.prefix'    => '$',
                'price.currency'  => 'CLP',
                'price.label'     => 'Precio en pesos chilenos',

                'prop.bedrooms'   => 'Dormitorios',
                'prop.bathrooms'  => 'Baños',
                'prop.sqm'        => 'm²',
                'prop.available'  => 'Disponible',
                'prop.reserved'   => 'Reservada',
                'prop.sold'       => 'Vendida',

                'form.name'       => 'Tu nombre',
                'form.email'      => 'Correo',
                'form.phone'      => 'Teléfono',
                'form.message'    => 'Tu mensaje',
                'form.send'       => 'Enviar',
                'form.required'   => 'Campo requerido',

                'cta.contact'     => 'Solicitar visita',
                'cta.viewMore'    => 'Ver más propiedades',
                'cta.calculate'   => 'Simular dividendo',

                'country.label'   => 'Chile',
                'country.phone'   => '+56 2',
            ],
        ];
    }
}
