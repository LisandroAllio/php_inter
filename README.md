# 🚀 Formas de levantar la aplicación

Existen **dos formas** de levantar la aplicación, dependiendo del entorno que quieras utilizar.

---

## 1. Ambos contenedores en una misma instancia (usando Docker Compose)

Esta versión utiliza el siguiente **Docker Compose**, que por defecto crea una **network interna** donde ambos contenedores se comunican entre sí a través de su **nombre de servicio**.

- El servicio **`db`** (base de datos) usa la imagen de MySQL 5.7.  
- El servicio **`php-front`** (frontend) usa un **Dockerfile personalizado** que configura todo el entorno PHP.

### 📄 Archivo `docker-compose.yml`

```yaml
services:
  db:
    image: mysql:5.7
    container_name: db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: "rootpass"
      MYSQL_DATABASE: "sample"
      MYSQL_USER: "sampleuser"
      MYSQL_PASSWORD: "samplepass"
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      - ./sql/db.sql:/docker-entrypoint-initdb.d/db.sql

  php-front:
    container_name: php-front
    restart: always
    build:
      context: .
      dockerfile: frontend/Dockerfile
    environment:
      DB_HOST: db
    ports:
      - "80:80"
    depends_on:
      - db

volumes:
  mysql_data:
```

---

## 2. Cada contenedor en una instancia distinta dentro de una misma VPC (AWS)

### 🗄️ Base de Datos (MySQL)

Existen **dos alternativas** para levantar la base de datos:

#### 🔹 Opción A — Usar la imagen oficial de MySQL 8.0 con autenticación compatible

Por problemas de versión, MySQL 8 utiliza el método de autenticación `caching_sha2_password`, que **no es compatible con PHP 7.2**.  
Para solucionarlo, corré el contenedor especificando el plugin de autenticación compatible:

```bash
docker run -d   --name mysql-db   -e MYSQL_ROOT_PASSWORD=rootpass   -e MYSQL_USER=sampleuser   -e MYSQL_PASSWORD=samplepass   -e MYSQL_DATABASE=sample   -v /var/lib/mysql   -p 3306:3306   mysql:8.0   --default-authentication-plugin=mysql_native_password
```

#### 🔹 Opción B — Clonar el repositorio y construir tu propia imagen personalizada

Esta versión usa un **Dockerfile** dentro del directorio `db/` que:
- Define las variables de entorno necesarias.
- Inicializa la base de datos automáticamente con el script `sql/db.sql`.

```bash
# Desde la carpeta db/
docker build -t my-mysql-db .
```

Luego ejecutá el contenedor:

```bash
docker run -d -p 3306:3306 --name db-container my-mysql-db
```

---

### 🖥️ FRONTEND (PHP + Apache)

1. Modificá la variable de entorno `DB_HOST` en el `Dockerfile` con la **IP privada** de la instancia EC2 donde corre la base de datos:

   ```dockerfile
   ENV DB_HOST=<PRIVATE_IP_DB>
   ```

2. Construí y levantá el contenedor:

   ```bash
   docker build -t php-front .
   docker run -d -p 80:80 --name php-app php-front
   ```

---

### ✅ Recomendacion
- Base de Datos: Clonar el repositorio y construir tu propia imagen personalizada
- Frontend: Levanta el frontend usando el Dockerfile (previamente configurar DB_HOST)



##  Resumen

| Escenario | Descripción | Comunicación |
|------------|--------------|---------------|
| **Compose local** | Ambos contenedores corren en la misma instancia | Usan una red interna de Docker (`DB_HOST=db`) |
| **Instancias separadas (AWS)** | Cada contenedor corre en una EC2 distinta | Usan la IP privada del contenedor de base de datos (`DB_HOST=<PRIVATE_IP_DB>`) |
