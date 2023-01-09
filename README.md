1. Definir la ruta de la base de datos sqlite
2. 
Ejecutar php artisan migrate
Ejecutar php artisan db:seed --class=FederalEntitySeeder
Ejecutar php artisan db:seed --class=MunicipalitySeeder
Ejecutar php artisan db:seed --class=SettlementTypeSeeder
Ejecutar php artisan db:seed --class=SettlementSeeder
o solamente php artisan migrate --seed

Pasos
1. Crear proyecto en GitHub
2. Desarrollo de la solución en el proyecto
2.1. Crear controladora. modelos, migraciones y seeders
2.2. Programar los seeder para el relleno de los datos según la fuente de datos en XML
2.3. Configurar sqlite para base de datos y ejecutar migraciones
2.4. Desarrollar lógica de negocio en el modelo
2.5. Crear la ruta del API y la function en la clase controladora para que llame a la clase Service que implementa el servicio
2.6. En la clase service creado funciones para standarizar la salida en el formato requerido
2.7. Creación de pruebas unitarias para probar las funciones y seeders

3. Subir proyecto en GitHub

4. Publicar en AWS
4.1. Crear instancia ubuntu e instalar paquetes de php y el servidor web Apache2
4.2. Poner IP pública a la instancia
4.3. Descargar proyecto en la instancia con git
4.4. ejecutar php artisan optimize, config:clear and key:generate

5. Crear indexado en las tablas settlements y postal_codes para mejorar la velocidad de respuesta de las consultas. Y añadido el indexado en las clases migrations
