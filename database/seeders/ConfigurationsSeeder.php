<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

/**
 * Seeder de configuraciones del sistema.
 *
 * Crea las configuraciones iniciales: datos de la empresa, contacto,
 * dirección, horarios, redes sociales, SEO y ajustes del sitio.
 */
class ConfigurationsSeeder extends Seeder
{
    /**
     * Inserta todas las configuraciones predeterminadas del sistema.
     *
     * @return void
     */
    public function run(): void
    {
        $configurations = [
            // Company Info
            ['key' => 'company_name', 'value' => 'Tendejón Azael', 'group' => 'company', 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_slogan', 'value' => 'Tu tienda de confianza desde 2007', 'group' => 'company', 'type' => 'string', 'is_public' => 1],
            ['key' => 'company_description', 'value' => 'Tienda de abarrotes con los mejores precios y atención personalizada.', 'group' => 'company', 'type' => 'text', 'is_public' => 1],
            
            // Contact Info
            ['key' => 'contact_email', 'value' => 'contacto@tendejonazael.com', 'group' => 'contact', 'type' => 'string', 'is_public' => 1],
            ['key' => 'contact_phone_1', 'value' => '9911161668', 'group' => 'contact', 'type' => 'string', 'is_public' => 1],
            ['key' => 'contact_phone_2', 'value' => '9911078633', 'group' => 'contact', 'type' => 'string', 'is_public' => 1],
            ['key' => 'contact_whatsapp', 'value' => '9911161668', 'group' => 'contact', 'type' => 'string', 'is_public' => 1],
            
            // Address
            ['key' => 'address_street', 'value' => 'Calle Principal', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            ['key' => 'address_city', 'value' => 'Mérida', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            ['key' => 'address_state', 'value' => 'Yucatán', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            ['key' => 'address_zip_code', 'value' => '97000', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            ['key' => 'address_country', 'value' => 'México', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            ['key' => 'address_maps_url', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.114705030224!2d-89.6217!3d20.967', 'group' => 'address', 'type' => 'string', 'is_public' => 1],
            
            // Business Hours
            ['key' => 'hours_weekdays', 'value' => '7:00 AM - 10:00 PM', 'group' => 'hours', 'type' => 'string', 'is_public' => 1],
            ['key' => 'hours_saturday', 'value' => '7:00 AM - 10:00 PM', 'group' => 'hours', 'type' => 'string', 'is_public' => 1],
            ['key' => 'hours_sunday', 'value' => '7:00 AM - 10:00 PM', 'group' => 'hours', 'type' => 'string', 'is_public' => 1],
            
            // Social Media
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social', 'type' => 'string', 'is_public' => 1],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social', 'type' => 'string', 'is_public' => 1],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social', 'type' => 'string', 'is_public' => 1],
            
            // SEO
            ['key' => 'seo_title', 'value' => 'Tendejón Azael - Tu tienda de confianza', 'group' => 'seo', 'type' => 'string', 'is_public' => 1],
            ['key' => 'seo_description', 'value' => 'Tendejón Azael, tu tienda de abarrotes con los mejores precios y atención personalizada desde 2007.', 'group' => 'seo', 'type' => 'text', 'is_public' => 1],
            ['key' => 'seo_keywords', 'value' => 'abarrotes, tienda, Mérida, Yucatán, productos', 'group' => 'seo', 'type' => 'string', 'is_public' => 1],
            
            // Site Settings
            ['key' => 'site_maintenance', 'value' => 'false', 'group' => 'site', 'type' => 'boolean', 'is_public' => 0],
            ['key' => 'site_items_per_page', 'value' => '12', 'group' => 'site', 'type' => 'integer', 'is_public' => 0],
            ['key' => 'site_timezone', 'value' => 'America/Merida', 'group' => 'site', 'type' => 'string', 'is_public' => 0],
            ['key' => 'site_locale', 'value' => 'es', 'group' => 'site', 'type' => 'string', 'is_public' => 1],
        ];

        foreach ($configurations as $config) {
            Configuration::create($config);
        }

        echo "✓ Configurations seeded successfully!\n";
    }
}
