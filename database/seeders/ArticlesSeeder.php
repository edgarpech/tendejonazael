<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
	public function run(): void
	{
		$articles = [
			[
				'title' => '¿Qué llevar a tus vacaciones en Chabihau? Guía completa',
				'slug' => 'que-llevar-vacaciones-chabihau',
				'excerpt' => 'Planifica tu visita a Chabihau con esta lista de todo lo que necesitas comprar al llegar al puerto. Desde agua purificada hasta snacks para la playa.',
				'category' => 'guias',
				'content' => '<p>Chabihau es uno de los destinos de playa más tranquilos y auténticos de la costa yucateca. Si planeas pasar unos días en este hermoso puerto, es importante que llegues preparado con los productos básicos para disfrutar al máximo tu estancia.</p>

<h2>Hidratación: lo más importante</h2>
<p>El calor en la costa de Yucatán puede ser intenso, especialmente entre marzo y septiembre. Te recomendamos llevar suficiente <strong>agua purificada</strong> — al menos 2 litros por persona al día. En Tendejón Azael encontrarás garrafones de 20 litros, botellas individuales y agua de sabor para toda la familia.</p>

<h2>Protección solar y básicos de playa</h2>
<p>No olvides tu protector solar, repelente de mosquitos y sombreros. Aunque estos productos los puedes adquirir antes de llegar, en la tienda siempre tenemos disponibles las marcas más populares para que no te falte nada.</p>

<h2>Snacks y botanas para la playa</h2>
<p>Nada mejor que disfrutar la brisa del mar con unas buenas botanas. Te recomendamos llevar:</p>
<ul>
<li><strong>Papas fritas y cacahuates:</strong> Clásicos que nunca fallan.</li>
<li><strong>Galletas y dulces:</strong> Para los más pequeños de la casa.</li>
<li><strong>Chicharrones y botanas:</strong> Perfectos para compartir en grupo.</li>
</ul>

<h2>Bebidas para toda la familia</h2>
<p>Además del agua, asegúrate de llevar refrescos, jugos y bebidas para toda la familia. En Tendejón Azael tenemos refrigeradores abiertos donde puedes tomar tus bebidas ya heladas. También contamos con <strong>bolsitas de hielo de 1 kg</strong> para tu hielera.</p>

<h2>Para cocinar en tu casa de playa</h2>
<p>Si tu alojamiento tiene cocina, aprovecha para preparar tus propios alimentos. Los básicos que necesitarás son:</p>
<ul>
<li>Aceite, sal, azúcar y especias</li>
<li>Tortillas de maíz</li>
<li>Huevos, frijoles y arroz</li>
<li>Carnes frías y quesos para desayunos rápidos</li>
<li>Pasta de achiote y recado para cocinar al estilo yucateco</li>
</ul>

<h2>No olvides los básicos de limpieza</h2>
<p>Jabón para trastes, papel higiénico, bolsas de basura y servilletas son indispensables. Muchas casas de renta no incluyen estos artículos, así que es mejor llegar preparado.</p>

<h2>Prepárate para los cortes de luz</h2>
<p>En Chabihau los <strong>cortes de electricidad son frecuentes</strong>, especialmente en temporada de calor y lluvias. Te recomendamos tener a la mano <strong>velas, linternas o focos recargables</strong> para no quedarte a oscuras. En la tienda puedes encontrar velas y cerillos.</p>

<h2>Palapas y servicios en la playa</h2>
<p>Si buscas disfrutar la playa con comodidades, te recomendamos <strong>Sol, Mar y Arena</strong>, donde ofrecen renta de palapas por hora, pasadías, cuartos, renta de kayaks, servicio de comida, baños y regaderas. Es una excelente opción para pasar el día sin preocupaciones.</p>

<p>En <strong>Tendejón Azael</strong> encontrarás todo esto y más. Estamos en la <strong>Calle 21 entre 14 y 16</strong> en el centro de Chabihau, abiertos de 7:00 AM a 9:00 PM (en temporada vacacional extendemos hasta las 10:00 u 11:00 PM). ¡Te esperamos!</p>',
			],
			[
				'title' => 'Los mejores snacks para un día de playa en Yucatán',
				'slug' => 'mejores-snacks-dia-playa-yucatan',
				'excerpt' => 'Descubre los snacks ideales para disfrutar en la playa: desde botanas clásicas hasta opciones saludables que puedes encontrar en tu tienda de confianza.',
				'category' => 'recomendaciones',
				'content' => '<p>Un día de playa en la costa yucateca no está completo sin buenas botanas. Ya sea que visites Chabihau, Telchac Puerto o Dzilam de Bravo, aquí te compartimos los mejores snacks para llevar a la playa.</p>

<h2>Botanas saladas clásicas</h2>
<p>Las favoritas de siempre nunca decepcionan:</p>
<ul>
<li><strong>Doritos y Ruffles:</strong> Ideales para compartir en grupo.</li>
<li><strong>Cacahuates japoneses:</strong> Ligeros y adictivos.</li>
<li><strong>Chicharrones de harina:</strong> Con salsa Valentina y limón, un clásico mexicano.</li>
<li><strong>Takis:</strong> Para los que disfrutan el picante bajo el sol.</li>
</ul>

<h2>Opciones dulces</h2>
<p>Para los golosos de la familia:</p>
<ul>
<li><strong>Mazapanes y palanquetas:</strong> Dulces tradicionales que no se derriten con el calor.</li>
<li><strong>Galletas Marías:</strong> Perfectas con un café matutino frente al mar.</li>
<li><strong>Pulparindo y dulces enchilados:</strong> Dulces típicos de México.</li>
</ul>

<h2>Opciones más saludables</h2>
<p>Si prefieres cuidar tu alimentación sin sacrificar el sabor:</p>
<ul>
<li><strong>Pepitas de calabaza:</strong> Un snack yucateco por excelencia.</li>
<li><strong>Barras de granola:</strong> Prácticas y nutritivas.</li>
<li><strong>Frutas secas:</strong> Mango, piña y arándanos deshidratados.</li>
</ul>

<h2>Bebidas para acompañar</h2>
<p>No olvides hidratarte constantemente. El agua es fundamental, pero puedes complementar con refrescos y aguas de sabor. Lleva tu hielera con <strong>bolsitas de hielo de 1 kg</strong> — las bebidas frías hacen toda la diferencia bajo el sol.</p>

<p>Recuerda siempre <strong>recoger tu basura</strong> al salir de la playa. Chabihau es un lugar hermoso que debemos cuidar entre todos. ¡En Tendejón Azael encontrarás todos estos snacks y más, listos para tu día perfecto en la playa!</p>',
			],
			[
				'title' => 'Chabihau: historia y encanto de un puerto yucateco',
				'slug' => 'chabihau-historia-encanto-puerto-yucateco',
				'excerpt' => 'Conoce la historia de Chabihau, un tranquilo puerto pesquero en la costa de Yucatán que se ha convertido en un destino favorito para vacacionistas.',
				'category' => 'chabihau',
				'content' => '<p>Chabihau es una pequeña comunidad costera ubicada en el municipio de Yobaín, en la costa norte de Yucatán, México. Con su playa de aguas tranquilas y su ambiente relajado, este puerto se ha ganado un lugar especial en el corazón de los yucatecos y visitantes.</p>

<h2>Orígenes del nombre</h2>
<p>El nombre "Chabihau" proviene del <strong>idioma maya</strong> y significa "donde el oso hormiguero (Chab) abre camino (haw)". Es un término que funciona tanto como patronímico como toponímico, reflejando la profunda conexión de la región con la cultura maya que habitó estas tierras antes de la conquista de Yucatán. La zona perteneció al cacicazgo de Ah Kin Chel durante la época prehispánica.</p>

<h2>De puerto pesquero a destino vacacional</h2>
<p>Durante décadas, Chabihau fue principalmente un pueblo de pescadores. Los habitantes locales vivían de la pesca del mero, pulpo, camarón y otras especies del Golfo de México. Con el tiempo, las familias de ciudades cercanas como Motul y Mérida comenzaron a construir casas de descanso, atraídas por la tranquilidad del lugar.</p>

<p>A diferencia de destinos más comerciales como Progreso o Celestún, Chabihau ha mantenido su esencia de pueblo costero. No encontrarás grandes hoteles ni cadenas de restaurantes, sino un ambiente familiar donde todos se conocen.</p>

<h2>Temporadas de mayor afluencia</h2>
<p>Las temporadas más concurridas en Chabihau son:</p>
<ul>
<li><strong>Semana Santa:</strong> Miles de familias yucatecas visitan los puertos para disfrutar del mar. Los negocios locales extienden su horario hasta las 10:00 u 11:00 de la noche.</li>
<li><strong>Verano (julio-agosto):</strong> Vacaciones escolares que llenan las casas de playa.</li>
<li><strong>Fines de semana largos:</strong> Puentes y días festivos atraen visitantes de Mérida y alrededores.</li>
</ul>

<h2>Qué hacer en Chabihau</h2>
<p>Aunque es un pueblo pequeño, hay varias actividades para disfrutar:</p>
<ul>
<li>Caminar por la playa al amanecer o atardecer</li>
<li>Observar aves en la ría y los manglares cercanos</li>
<li>Pescar desde el muelle</li>
<li>Disfrutar de mariscos frescos en los restaurantes locales</li>
<li>Rentar kayaks y palapas en <strong>Sol, Mar y Arena</strong>, que también ofrece cuartos, pasadías, servicio de comida, baños y regaderas</li>
</ul>

<h2>Cuidado con los cocodrilos</h2>
<p>Es importante mencionar que en la zona de manglares y la ría de Chabihau se han avistado <strong>cocodrilos</strong>. Estos animales son parte del ecosistema natural de la región. Te pedimos respetar su espacio, no acercarte a las zonas de manglar de noche y estar atento, especialmente si caminas por áreas cercanas a la ría.</p>

<p>Y por supuesto, cuando necesites abastecerte de productos básicos, bebidas, snacks o cualquier artículo para tu estancia, <strong>Tendejón Azael</strong> está aquí para atenderte en la <strong>Calle 21 entre 14 y 16</strong>, abierto todos los días de 7:00 AM a 9:00 PM (horario extendido en vacaciones).</p>',
			],
			[
				'title' => 'Guía de Semana Santa en Chabihau: todo lo que necesitas saber',
				'slug' => 'guia-semana-santa-chabihau',
				'excerpt' => 'Prepárate para Semana Santa en Chabihau con esta guía práctica: qué llevar, horarios, recomendaciones y dónde encontrar lo que necesitas.',
				'category' => 'guias',
				'content' => '<p>Semana Santa es la temporada más esperada en Chabihau. Miles de familias visitan este puerto yucateco para disfrutar del sol, la playa y la convivencia familiar. Aquí te compartimos todo lo que necesitas saber para que tu visita sea perfecta.</p>

<h2>¿Cuándo llegar?</h2>
<p>La mayoría de las familias llegan el Viernes de Dolores o el Sábado de Gloria y se quedan toda la semana. Si quieres evitar el tráfico más pesado, te recomendamos llegar temprano entre semana. Los caminos desde Motul y Mérida suelen congestionarse los fines de semana.</p>

<h2>Combustible para el viaje</h2>
<p>Recuerda cargar gasolina antes de llegar al puerto. Las <strong>gasolineras más cercanas</strong> están en <strong>Motul, Telchac Puerto, Dzilam de Bravo y Dzidzantún</strong>. En Chabihau no hay estaciones de servicio.</p>

<h2>Qué llevar a tu casa de playa</h2>
<p>Además de tu ropa y artículos personales, no olvides:</p>
<ul>
<li><strong>Despensa completa:</strong> Aunque en Tendejón Azael encuentras de todo, durante los días pico la demanda es alta. Te recomendamos hacer tus compras al llegar.</li>
<li><strong>Hielo:</strong> El calor en abril puede superar los 38°C. Tenemos <strong>bolsitas de hielo de 1 kg</strong> disponibles.</li>
<li><strong>Protector solar:</strong> Factor 50+ es lo recomendable para la costa yucateca.</li>
<li><strong>Repelente de mosquitos:</strong> Los moscos son más activos al atardecer.</li>
<li><strong>Velas y linternas:</strong> Los <strong>cortes de luz son frecuentes</strong> en Chabihau, así que es mejor estar preparado con focos recargables o velas.</li>
<li><strong>Hamacas:</strong> Si tu casa no tiene, son esenciales para descansar al estilo yucateco.</li>
</ul>

<h2>Seguridad en la playa</h2>
<p>Chabihau tiene una playa generalmente tranquila, pero es importante tomar precauciones:</p>
<ul>
<li>Supervisa siempre a los niños cerca del agua</li>
<li>Evita nadar si hay bandera roja</li>
<li>No dejes objetos de valor en la playa sin supervisión</li>
<li>Hidratarse constantemente para evitar golpes de calor</li>
<li>Ten cuidado en zonas de manglar y ría — se han avistado <strong>cocodrilos</strong> en su hábitat natural</li>
</ul>

<h2>Servicios en la playa</h2>
<p>Si buscas pasar el día con comodidades, <strong>Sol, Mar y Arena</strong> ofrece renta de palapas por hora, pasadías, cuartos, renta de kayaks, servicio de comida, baños y regaderas. Es una excelente opción para familias.</p>

<h2>Eventos y tradiciones</h2>
<p>Durante Semana Santa, es común ver procesiones religiosas en los pueblos cercanos, ferias con juegos mecánicos y puestos de comida. En Chabihau mismo, la comunidad organiza actividades recreativas y torneos de pesca.</p>

<h2>Horarios de Tendejón Azael en Semana Santa</h2>
<p>Durante toda la temporada de Semana Santa <strong>extendemos nuestro horario hasta las 10:00 u 11:00 de la noche</strong> (normalmente cerramos a las 9:00 PM). Sabemos que nuestros clientes necesitan encontrar productos a cualquier hora, así que estamos aquí para ti. Nos encuentras en la <strong>Calle 21 entre 14 y 16</strong>.</p>

<p>¡Te esperamos en Chabihau para que vivas la mejor Semana Santa!</p>',
			],
			[
				'title' => 'Productos básicos para armar tu despensa de vacaciones',
				'slug' => 'productos-basicos-despensa-vacaciones',
				'excerpt' => 'Lista completa de productos esenciales para armar tu despensa cuando llegas a tu casa de playa. Organizada por categorías para que no olvides nada.',
				'category' => 'recomendaciones',
				'content' => '<p>Llegar a tu casa de playa y tener la despensa lista es el primer paso para unas vacaciones sin estrés. Aquí te compartimos una guía organizada por categorías para que no te falte nada durante tu estancia en Chabihau.</p>

<h2>Desayunos</h2>
<p>El desayuno es la comida más importante, especialmente si planeas pasar el día en la playa. Los básicos son:</p>
<ul>
<li>Huevos (al menos una docena para una familia de 4)</li>
<li>Pan de caja o teleras para hacer tortas</li>
<li>Jamón, queso y mantequilla</li>
<li>Cereal y leche</li>
<li>Café, azúcar y crema</li>
<li>Jugo de naranja</li>
</ul>

<h2>Comidas y cenas</h2>
<p>Para preparar comidas sencillas y rápidas:</p>
<ul>
<li>Arroz y frijoles (enlatados o para cocinar)</li>
<li>Pasta y salsa para espagueti</li>
<li>Atún y sardinas</li>
<li>Tortillas de maíz</li>
<li>Salchichas para asar</li>
<li>Verduras básicas: tomate, cebolla, chile, cilantro, limones</li>
<li>Aceite, sal, pimienta y condimentos</li>
</ul>

<h2>Bebidas</h2>
<p>La hidratación es clave en el calor yucateco:</p>
<ul>
<li>Agua purificada (garrafón de 20L + botellas individuales)</li>
<li>Refrescos y aguas de sabor</li>
<li>Leche</li>
<li>Suero oral (por si alguien se deshidrata)</li>
</ul>

<h2>Limpieza y hogar</h2>
<p>Muchas casas de renta no incluyen artículos de limpieza:</p>
<ul>
<li>Papel higiénico y servilletas</li>
<li>Jabón para trastes y esponja</li>
<li>Bolsas de basura</li>
<li>Cloro o desinfectante multiusos</li>
</ul>

<h2>Hielo</h2>
<p>El hielo es un artículo de primera necesidad en la playa. En Tendejón Azael tenemos <strong>bolsitas de hielo de 1 kg</strong>, perfectas para llenar tu hielera y mantener tus bebidas frías todo el día.</p>

<h2>Prepárate para cortes de luz</h2>
<p>Los cortes de electricidad son comunes en Chabihau. Te sugerimos incluir en tu lista <strong>velas, cerillos y una linterna</strong> para estar preparado.</p>

<p>En <strong>Tendejón Azael</strong> encontrarás todos estos productos a precios accesibles. Puedes pasar al llegar al puerto y surtir tu despensa completa en un solo lugar. Estamos en la <strong>Calle 21 entre 14 y 16</strong>, abiertos de 7:00 AM a 9:00 PM todos los días (en temporada vacacional hasta las 10:00 u 11:00 PM).</p>',
			],
			[
				'title' => '¿Por qué elegir una tienda local en Chabihau?',
				'slug' => 'por-que-elegir-tienda-local-chabihau',
				'excerpt' => 'Descubre las ventajas de comprar en una tienda local como Tendejón Azael: precios justos, productos frescos, trato personalizado y apoyo a la comunidad.',
				'category' => 'comunidad',
				'content' => '<p>En una época de grandes cadenas comerciales y compras en línea, las tiendas locales siguen siendo el corazón de las comunidades pequeñas como Chabihau. Aquí te contamos por qué comprar local hace la diferencia.</p>

<h2>Conocemos a nuestros clientes</h2>
<p>En Tendejón Azael conocemos a nuestros clientes por nombre. Sabemos qué marcas prefieren, qué productos buscan y cuándo necesitan algo especial. Este trato personalizado es algo que ninguna cadena comercial puede ofrecer. Si necesitas un producto que no tenemos, hacemos lo posible por conseguirlo para tu próxima visita.</p>

<h2>Productos adaptados a la zona</h2>
<p>Nuestra selección de productos está pensada específicamente para las necesidades de quienes viven y visitan Chabihau. Siempre tenemos disponible:</p>
<ul>
<li><strong>Hielo:</strong> Bolsitas de 1 kg, uno de los productos más demandados en la playa.</li>
<li><strong>Bebidas frías:</strong> Nuestros refrigeradores están siempre surtidos con refrescos, aguas y jugos.</li>
<li><strong>Artículos de temporada:</strong> En Semana Santa y verano reforzamos nuestro inventario.</li>
<li><strong>Productos yucatecos:</strong> Pasta de achiote, recado, salsas locales y más.</li>
</ul>

<h2>Precios justos y accesibles</h2>
<p>Entendemos que las familias buscan ahorrar durante sus vacaciones. Por eso mantenemos precios competitivos en todos nuestros productos. No necesitas manejar hasta Motul o Mérida para encontrar buenos precios — aquí en Chabihau te ofrecemos lo que necesitas sin el viaje extra.</p>

<h2>Formas de pago</h2>
<p>Aceptamos <strong>efectivo</strong> y <strong>tarjeta de débito y crédito</strong> (con un 5% de comisión). Sabemos que no siempre es fácil encontrar un cajero en Chabihau, así que ofrecemos opciones para tu comodidad.</p>

<h2>Contribuimos a la economía local</h2>
<p>Cuando compras en Tendejón Azael, estás apoyando directamente a una familia de Chabihau. Los ingresos de la tienda se quedan en la comunidad: generamos empleo local, compramos a proveedores de la región y participamos en las actividades del pueblo.</p>

<h2>Estamos aquí cuando nos necesitas</h2>
<p>Abrimos los 7 días de la semana, de 7:00 AM a 9:00 PM (en temporada vacacional extendemos hasta las 10:00 u 11:00 PM). Si se te acaba el hielo a las 8 de la noche o necesitas algo temprano en la mañana, estamos aquí. Es la ventaja de tener una tienda comprometida con su comunidad.</p>

<p>Desde 2005, cuando comenzamos como un pequeño puesto de Coca-Cola, y formalmente desde <strong>2007</strong> con el alta en Hacienda, <strong>Tendejón Azael</strong> ha sido parte de la vida de Chabihau. Gracias por confiar en nosotros.</p>',
			],
			[
				'title' => 'Recetas fáciles para cocinar en tu casa de playa',
				'slug' => 'recetas-faciles-cocinar-casa-playa',
				'excerpt' => 'Recetas rápidas y deliciosas que puedes preparar en tu casa de playa con ingredientes que encuentras en la tienda. Perfectas para vacaciones.',
				'category' => 'recomendaciones',
				'content' => '<p>Cocinar en la casa de playa no tiene que ser complicado. Con ingredientes básicos que puedes encontrar en Tendejón Azael, puedes preparar comidas deliciosas para toda la familia. Aquí te compartimos algunas recetas favoritas.</p>

<h2>Huevos motuleños (Desayuno yucateco)</h2>
<p>Un clásico yucateco que es fácil de hacer:</p>
<ul>
<li>Fríe tortillas de maíz en aceite hasta que estén ligeramente doradas</li>
<li>Colócalas en un plato y unta frijoles negros refritos encima</li>
<li>Pon un huevo estrellado sobre cada tortilla</li>
<li>Baña con salsa de tomate y agrega chícharos, jamón picado y queso rallado</li>
<li>Sirve con rodajas de plátano frito</li>
</ul>
<p><em>Ingredientes que encuentras en la tienda: huevos, tortillas, frijoles, jamón, queso, salsa, aceite.</em></p>

<h2>Tacos de atún a la mexicana (Comida rápida)</h2>
<p>Perfectos cuando no quieres complicarte:</p>
<ul>
<li>Abre una lata de atún y escúrrela</li>
<li>Mezcla con tomate, cebolla y cilantro picados</li>
<li>Agrega limón, sal y chile al gusto</li>
<li>Sirve en tortillas de maíz calientes</li>
</ul>
<p><em>Ingredientes disponibles: atún en lata, tortillas, tomate, cebolla, limones, sal.</em></p>

<h2>Espagueti con salchichas (Favorito de los niños)</h2>
<p>Simple, rápido y les encanta a los pequeños:</p>
<ul>
<li>Hierve la pasta según las instrucciones del paquete</li>
<li>Fríe salchichas cortadas en rodajas</li>
<li>Mezcla todo con salsa cátsup o salsa para espagueti</li>
<li>Espolvorea queso rallado encima</li>
</ul>
<p><em>Todo disponible en la tienda: pasta, salchichas, salsa, queso.</em></p>

<h2>Ceviche de emergencia (Cena ligera)</h2>
<p>Si encuentras pescado fresco en el muelle:</p>
<ul>
<li>Corta el pescado en cubitos pequeños y cúbrelo con jugo de limón</li>
<li>Refrigera por al menos 2 horas</li>
<li>Agrega tomate, cebolla morada, cilantro y chile habanero picados</li>
<li>Sazona con sal y sirve con tostadas o galletas saladas</li>
</ul>
<p><em>De la tienda necesitas: limones, tomate, cebolla, cilantro, tostadas, sal.</em></p>

<h2>Agua de jamaica (Bebida para todo el día)</h2>
<ul>
<li>Hierve 2 litros de agua con un puño de flor de jamaica por 10 minutos</li>
<li>Cuela, agrega azúcar al gusto y deja enfriar</li>
<li>Sirve con mucho hielo</li>
</ul>
<p><em>Flor de jamaica y azúcar disponibles en la tienda.</em></p>

<p>Lo mejor de cocinar en la playa es que todo sabe mejor con la brisa del mar. ¡Visita <strong>Tendejón Azael</strong> en la <strong>Calle 21 entre 14 y 16</strong> para conseguir todos tus ingredientes!</p>',
			],
			[
				'title' => 'Cuidando Chabihau: consejos para unas vacaciones responsables',
				'slug' => 'cuidando-chabihau-vacaciones-sustentables',
				'excerpt' => 'Chabihau es un lugar especial que debemos cuidar. Aprende cómo disfrutar tus vacaciones de forma responsable y respetar el entorno natural.',
				'category' => 'comunidad',
				'content' => '<p>Chabihau es un lugar privilegiado con playas tranquilas, manglares llenos de vida silvestre y una comunidad que cuida su entorno. Como visitantes, tenemos la responsabilidad de mantenerlo así. Aquí te compartimos prácticas sencillas para unas vacaciones más responsables.</p>

<h2>Manejo de basura</h2>
<p>Este es el tema más importante. Cada temporada alta, la cantidad de basura en las playas aumenta significativamente. Para ayudar:</p>
<ul>
<li><strong>Lleva bolsas de basura a la playa:</strong> Separa lo orgánico de lo inorgánico.</li>
<li><strong>No entierres basura en la arena:</strong> El mar la desentierra y contamina el agua.</li>
<li><strong>Recoge tu basura y un poco más:</strong> Si todos recogemos un poco extra, la playa se mantiene impecable.</li>
<li><strong>Deposita tu basura en los contenedores:</strong> Si no encuentras uno cerca, llévala a tu casa y deposítala correctamente.</li>
</ul>

<h2>Respeta la vida silvestre</h2>
<p>Los manglares de Chabihau son hogar de docenas de especies de aves, incluidos flamencos, garzas y pelícanos. Además, se han avistado <strong>cocodrilos</strong> en la zona de la ría y los manglares. Para tu seguridad y la de estos animales:</p>
<ul>
<li>No te acerques a las zonas de manglar de noche</li>
<li>No alimentes a los animales silvestres</li>
<li>Respeta el área natural de los cocodrilos — mantén distancia segura</li>
<li>Si ves un nido de tortuga marina, no lo toques y reporta a las autoridades locales</li>
</ul>

<h2>Consume local</h2>
<p>Comprar en tiendas locales como Tendejón Azael en lugar de traer todo desde la ciudad apoya directamente a las familias de la comunidad. Además, encontrarás productos frescos y todo lo necesario para tu estancia.</p>

<h2>Disfruta los servicios de la playa</h2>
<p>En lugar de llevar montones de equipo, aprovecha los servicios que ofrece <strong>Sol, Mar y Arena</strong>: renta de palapas por hora, pasadías, kayaks, servicio de comida, baños y regaderas. Así reduces la cantidad de desechables que generas.</p>

<p>Chabihau nos recibe con los brazos abiertos cada temporada. Cuidar este hermoso lugar es tarea de todos: residentes y visitantes. ¡Juntos podemos mantener nuestra playa limpia para las generaciones futuras!</p>',
			],
			[
				'title' => 'La historia de Tendejón Azael: dos décadas sirviendo a Chabihau',
				'slug' => 'historia-tendejon-azael',
				'excerpt' => 'Conoce la historia de Tendejón Azael, desde sus humildes inicios en 2005 como un pequeño puesto de Coca-Cola hasta convertirse en la tienda de confianza de Chabihau.',
				'category' => 'comunidad',
				'content' => '<p>Tendejón Azael es parte de la historia de Chabihau. Lo que hoy es una tienda de abarrotes completa comenzó hace más de dos décadas como un sueño familiar en este tranquilo puerto de la costa norte de Yucatán.</p>

<h2>Los inicios: un puesto de Coca-Cola (2005)</h2>
<p>Todo comenzó en <strong>2005</strong>, cuando la familia decidió montar un <strong>pequeño puesto de Coca-Cola</strong> en Chabihau. Era algo sencillo: un espacio modesto donde se vendían refrescos a los vecinos y a los primeros visitantes que llegaban al puerto. Pero la necesidad de la comunidad era clara — hacía falta un lugar donde comprar los productos básicos sin tener que viajar hasta Motul.</p>

<h2>Formalización y crecimiento (2007)</h2>
<p>En <strong>2007</strong> se dio un paso importante: el <strong>alta ante Hacienda</strong>, formalizando el negocio como Tendejón Azael. El nombre "Tendejón" refleja nuestras raíces yucatecas — así es como en la península llamamos a las tiendas de la esquina. <strong>Azael</strong>, el nombre de uno de los hijos de la familia, le da ese toque personal que nos caracteriza.</p>

<p>A partir de ese momento, la tienda comenzó a crecer. De vender solo refrescos, se fue ampliando el inventario para incluir abarrotes, snacks, productos de limpieza, higiene personal, hielo y todo lo que la comunidad y los visitantes necesitaban.</p>

<h2>Crecimiento junto a la comunidad</h2>
<p>A lo largo de estos años, hemos crecido junto con Chabihau. Hoy contamos con un catálogo amplio que incluye:</p>
<ul>
<li>Abarrotes y productos de despensa</li>
<li>Bebidas frías: refrescos, aguas, jugos</li>
<li>Snacks y botanas de todas las marcas</li>
<li>Productos de higiene y limpieza</li>
<li>Bolsitas de hielo de 1 kg</li>
<li>Artículos de temporada</li>
</ul>

<h2>Nuestro compromiso</h2>
<p>Desde el primer día, nuestro compromiso ha sido simple: estar aquí cuando nos necesitan. Por eso abrimos los 7 días de la semana, de <strong>7:00 AM a 9:00 PM</strong> (en temporada vacacional extendemos hasta las 10:00 u 11:00 PM). Sabemos que en vacaciones las necesidades surgen a cualquier hora.</p>

<h2>Más que una tienda</h2>
<p>Tendejón Azael no es solo un lugar para comprar productos. Es un punto de encuentro donde los vecinos se saludan, donde los visitantes piden recomendaciones sobre la zona y donde siempre hay una sonrisa para recibirte. Nos enorgullece ser parte de la vida cotidiana de Chabihau.</p>

<h2>Mirando al futuro</h2>
<p>Seguimos trabajando para mejorar: ampliando nuestro catálogo, actualizando nuestros precios para ser más competitivos y ahora también con presencia en línea para que puedas conocer nuestros productos antes de visitarnos.</p>

<p>Gracias a todos los clientes que nos han acompañado en este camino. Su confianza es lo que nos impulsa. Visítanos en la <strong>Calle 21 entre 14 y 16</strong> de Chabihau. <strong>¡Los esperamos!</strong></p>',
			],
			[
				'title' => 'Explorando la costa norte de Yucatán: pueblos cercanos a Chabihau',
				'slug' => 'costa-norte-yucatan-pueblos-cercanos-chabihau',
				'excerpt' => 'Descubre los destinos costeros cerca de Chabihau: Telchac Puerto, Dzilam de Bravo, San Crisanto y más. Una guía para excursiones de un día.',
				'category' => 'chabihau',
				'content' => '<p>Chabihau tiene una ubicación privilegiada en la costa norte de Yucatán, rodeado de otros puertos y comunidades costeras que valen la pena visitar. Si ya estás instalado en tu casa de playa, aquí te compartimos opciones para excursiones de un día.</p>

<h2>Telchac Puerto — 15 minutos al poniente</h2>
<p>Telchac Puerto es una de las playas más populares de la costa yucateca. Tiene más infraestructura turística que Chabihau, con restaurantes, tiendas y un malecón renovado. Es perfecto para pasar un día diferente:</p>
<ul>
<li>Restaurantes con mariscos frescos</li>
<li>Malecón para caminar al atardecer</li>
<li>Tiendas de artesanías</li>
</ul>

<h2>San Crisanto — 20 minutos al oriente</h2>
<p>San Crisanto es conocido por sus atractivos naturales. Ofrece:</p>
<ul>
<li>Tours en kayak por los manglares</li>
<li>Observación de flamencos y aves</li>
<li>Playa tranquila y poco concurrida</li>
</ul>

<h2>Dzilam de Bravo — 40 minutos al oriente</h2>
<p>Un pueblo pesquero auténtico donde puedes comprar pescado y mariscos directos del muelle. Es conocido por:</p>
<ul>
<li>La Reserva Estatal de Dzilam</li>
<li>Mariscos frescos y económicos</li>
<li>Ambiente de pueblo pesquero tradicional</li>
</ul>

<h2>Motul — 30 minutos al sur</h2>
<p>Aunque no es un puerto, Motul es la ciudad más cercana con servicios completos. Es famosa por ser la cuna de los huevos motuleños y ofrece:</p>
<ul>
<li>Mercado municipal con productos frescos</li>
<li>Restaurantes de comida yucateca</li>
<li>Supermercados y tiendas de mayor tamaño</li>
<li>Gasolinera y servicios bancarios</li>
</ul>

<h2>Consejos para tus excursiones</h2>
<ul>
<li>Lleva suficiente agua y protector solar</li>
<li>Carga combustible antes — las <strong>gasolineras</strong> están en <strong>Motul, Telchac Puerto, Dzilam de Bravo y Dzidzantún</strong></li>
<li>Los caminos costeros son de dos carriles, maneja con precaución</li>
<li>Lleva efectivo — no todos los lugares aceptan tarjeta</li>
<li>Ten cuidado con los <strong>cocodrilos</strong> en zonas de manglar y ría</li>
</ul>

<p>Antes de salir a explorar, pasa por <strong>Tendejón Azael</strong> en la <strong>Calle 21 entre 14 y 16</strong> a surtirte de agua, snacks y hielo para tu hielera. ¡Buen viaje!</p>',
			],
			[
				'title' => 'Temporada de nortes en Yucatán: qué esperar y cómo prepararte',
				'slug' => 'temporada-nortes-yucatan-prepararte',
				'excerpt' => 'Los nortes traen vientos fuertes y lluvias a la costa yucateca entre octubre y febrero. Aprende qué son, cómo afectan a Chabihau y qué necesitas tener en casa.',
				'category' => 'guias',
				'content' => '<p>Si vives o pasas temporadas largas en Chabihau, seguramente has experimentado los famosos "nortes": frentes fríos que llegan del norte del continente y traen vientos fuertes, oleaje alto, lluvias y temperaturas más frescas. Aquí te explicamos todo sobre esta temporada.</p>

<h2>¿Qué es un "norte"?</h2>
<p>Los nortes son sistemas meteorológicos que se originan en el norte de América y viajan hacia el sur, afectando la Península de Yucatán principalmente entre octubre y febrero. Se caracterizan por:</p>
<ul>
<li><strong>Vientos fuertes:</strong> Pueden superar los 80 km/h en la costa.</li>
<li><strong>Oleaje alto:</strong> El mar se pone picado y puede subir significativamente.</li>
<li><strong>Lluvias intermitentes:</strong> No necesariamente llueve mucho, pero la humedad aumenta.</li>
<li><strong>Descenso de temperatura:</strong> Puede bajar a 15-18°C, algo que en Yucatán se siente muy frío.</li>
</ul>

<h2>Cómo afectan a Chabihau</h2>
<p>Durante un norte fuerte, la playa puede cambiar completamente su aspecto. El mar sube hasta cubrir partes de la arena, los pescadores no salen a pescar y es recomendable no meterse al agua. Sin embargo, muchos visitantes disfrutan del espectáculo natural que ofrecen las olas rompiendo.</p>

<h2>Qué necesitas tener en casa</h2>
<p>Si te toca un norte durante tu estancia, asegúrate de tener:</p>
<ul>
<li><strong>Alimentos no perecederos:</strong> Atún, frijoles enlatados, galletas, pan</li>
<li><strong>Agua suficiente:</strong> En caso de que el norte sea prolongado</li>
<li><strong>Velas, linternas y focos recargables:</strong> Los <strong>cortes de luz son muy frecuentes</strong> en Chabihau, especialmente con vientos fuertes. Tener iluminación de respaldo es prácticamente obligatorio.</li>
<li><strong>Ropa abrigadora:</strong> Suéteres, cobijas y ropa cerrada</li>
<li><strong>Café y chocolate caliente:</strong> Para disfrutar el frío inusual del trópico</li>
</ul>

<h2>Actividades para un día de norte</h2>
<p>Cuando el mar no permite actividades de playa, puedes:</p>
<ul>
<li>Leer un buen libro en la hamaca (dentro de casa)</li>
<li>Cocinar en familia — es perfecto para preparar recetas más elaboradas</li>
<li>Juegos de mesa con la familia</li>
<li>Pasear por el pueblo cuando el viento aminore</li>
</ul>

<p>Los nortes son parte del encanto de la vida costera yucateca. En <strong>Tendejón Azael</strong> siempre estamos abiertos, llueva o truene, de 7:00 AM a 9:00 PM en la <strong>Calle 21 entre 14 y 16</strong>. ¡No dejes que un norte arruine tus vacaciones!</p>',
			],
		];

		foreach ($articles as $i => $article) {
			Article::create(array_merge($article, [
				'is_published' => true,
				'published_at' => now()->subDays(count($articles) - $i),
			]));
		}
	}
}
