<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('features')->insert(array(
            [
                'id' => 1,
                'name' => 'Resumen de ventas.',
                'description' => 'Home',
            ],
            [
                'id' => 2,
                'name' => 'Ordenes pendientes.',
                'description' => 'Home',
            ],
            [
                'id' => 3,
                'name' => 'Todas las ordenes.',
                'description' => 'Home',
            ],
            [
                'id' => 4,
                'name' => 'Cargue de productos ilimitados.',
                'description' => 'Product',
            ],
            [
                'id' => 5,
                'name' => 'Creacion de categorias ilimitadas.',
                'description' => 'Product',
            ],
            [
                'id' => 6,
                'name' => 'Importaci�n y exportaci�n masiva de productos.',
                'description' => 'Product',
            ],
            [
                'id' => 7,
                'name' => 'Variantes por articulo, talla, color entre otras.',
                'description' => 'Product',
            ],
            [
                'id' => 8,
                'name' => 'Ordenes de pedido.',
                'description' => 'Order',
            ],
            [
                'id' => 9,
                'name' => 'Administraci�n de clientes.',
                'description' => 'Client',
            ],
            [
                'id' => 10,
                'name' => 'Inicio de sesion con redes sociales.',
                'description' => 'Marketing',
            ],
            [
                'id' => 11,
                'name' => 'Cupones de descuento.',
                'description' => 'Marketing',
            ],
            [
                'id' => 12,
                'name' => 'Email marketing.',
                'description' => 'Marketing',
            ],
            [
                'id' => 13,
                'name' => 'Selecci�n m�ltiples templates.',
                'description' => 'Design',
            ],
            [
                'id' => 14,
                'name' => 'Cambiar logo.',
                'description' => 'Design',
            ],
            [
                'id' => 15,
                'name' => 'P�gina en construcci�n.',
                'description' => 'Design',
            ],
            [
                'id' => 16,
                'name' => 'Dise�o responsivo.',
                'description' => 'Design',
            ],
            [
                'id' => 17,
                'name' => 'Pasarelas de pago',
                'description' => 'Setting',
            ],
            [
                'id' => 18,
                'name' => 'Envios a trav�s de servientrega.',
                'description' => 'Setting',
            ],
            [
                'id' => 19,
                'name' => 'Subdomio gratis de Tendaz.com.',
                'description' => 'Setting',
            ],
            [
                'id' => 20,
                'name' => 'Integraci�n con mercadolibre.',
                'description' => 'Setting',
            ],
            [
                'id' => 21,
                'name' => 'SEO avanzado',
                'description' => 'Setting',
            ],
            [
                'id' => 22,
                'name' => 'Configuraci�n de redes sociales.',
                'description' => 'Setting',
            ],
            [
                'id' => 23,
                'name' => 'Cont�ctanos del cliente.',
                'description' => 'Setting',
            ],
            [
                'id' => 24,
                'name' => 'Multiples dominios.',
                'description' => 'Setting',
            ],
            [
                'id' => 25,
                'name' => 'Estadisticas avanzadas.',
                'description' => 'Stats',
            ],
            [
                'id' => 26,
                'name' => 'Producto con mayor facturaci�n.',
                'description' => 'Stats',
            ],
            [
                'id' => 27,
                'name' => 'Productos m�s vendidos.',
                'description' => 'Stats',
            ],
            [
                'id' => 28,
                'name' => 'An�lisis de tendencias, clientes y envio de emails con promociones dependiendo las busquedas que realice el cliente en el sitio.',
                'description' => 'Business',
            ],
            [
                'id' => 29,
                'name' => 'App movil de tienda.',
                'description' => 'App',
            ],
            [
                'id' => 30,
                'name' => 'Temas generales.',
                'description' => 'Help',
            ],
            [
                'id' => 31,
                'name' => 'Temas especificos con manuales.',
                'description' => 'Help',
            ],
            [
                'id' => 32,
                'name' => 'Chat de soporte.',
                'description' => 'Help',
            ],
            [
                'id' => 33,
                'name' => 'Vista de foros.',
                'description' => 'Help',
            ],
            [
                'id' => 34,
                'name' => 'Contacto de soporte.',
                'description' => 'Help',
            ]
        ));
    }
}
