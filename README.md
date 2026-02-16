<h1 align="center">📊 CRM - Sistema de Gestión Comercial</h1>

<p align="center">
  <strong>Sistema de gestión de ventas, productos y reportes</strong><br>
  Desarrollado con PHP 7.4, CodeIgniter y MySQL
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.4-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/CodeIgniter-Framework-red?style=for-the-badge&logo=codeigniter" />
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql" />
  <img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge" />
</p>

---

# 📌 Descripción

Este proyecto es un **CRM (Customer Relationship Management)** desarrollado en **PHP 7.4** utilizando el framework **CodeIgniter** y base de datos **MySQL**.

El sistema permite la gestión integral de:

- Ventas
- Productos
- Tiendas
- Reportes
- Deudas
- Anulación de ventas
- Consultas JSON para integraciones externas

Está estructurado para funcionar como aplicación web y también como API interna para consumo mediante peticiones HTTP.

---

Base de datos: MySQL  
Lenguaje: PHP 7.4  

---

# 🧩 Módulos Implementados

## 🔹 Gestión de Ventas

- Agregar venta
- Anular venta
- Obtener detalle de venta
- Reporte de ventas
- Cambio de JSON en reportes

Archivos relevantes:

- `Agregar_Venta_Reponer_Cambiar_JSON.php`
- `Anular_Venta_Reponer_Cambiar_JSON.php`
- `Obtener_Detalle_Venta.php`
- `Obtener_Reporte_Ventas_App.php`

---

## 🔹 Gestión de Productos

- Lista de productos activos
- Productos a transportar
- Detalle de productos

Archivos:

- `Obtener_Lista_Productos_Activos.php`
- `Obtener_Lista_Productos_A_Transportar.php`

---

## 🔹 Gestión de Tiendas

- Lista de tiendas
- Tiendas con deudas

Archivos:

- `Obtener_Lista_Tiendas_App.php`
- `Obtener_Lista_Tiendas_Con_Deudas_App.php`

---

## 🔹 Gestión de Deudas

- Reporte de deudas
- Reporte de deudas pagadas

Archivos:

- `Obtener_Reporte_Deudas_App.php`
- `Obtener_Reporte_Deudas_Pagadas_App.php`

---

## 🔹 Autenticación

- Login APP
- Control de acceso

Archivos:

- `LoginAPP.php`
- `LoginAPP_v1.php`

---

# ⚙️ Requisitos del Sistema

- PHP 7.4
- MySQL 5.7+
- Apache / Nginx
- XAMPP o servidor similar
- Composer (si aplica)
- CodeIgniter 3.x o compatible

---

# 🚀 Instalación

## 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/MaicolArt07/crm.git
cd crm

Proyecto privado / uso interno comercial.
