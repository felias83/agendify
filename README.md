# 📅 Agendify — RESTful API para Agendamiento de Citas

[![CI Pipeline](https://github.com/felias83/agendify/actions/workflows/ci.yml/badge.svg)](https://github.com/felias83/agendify/actions/workflows/ci.yml)
![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)
![Pest PHP](https://img.shields.io/badge/Testing-Pest%20PHP-00D2FF?style=flat)
![AWS S3](https://img.shields.io/badge/AWS-S3%20Storage-232F3E?style=flat&logo=amazon-aws)

**Agendify** es una API RESTful desarrollada en **Laravel 11** orientada al agendamiento inteligente de servicios. El sistema previene el solapamiento de horarios entre proveedores, permite la carga de archivos adjuntos (comprobantes/documentos) almacenados en la nube de **AWS S3** y cuenta con una arquitectura testeada al 100% mediante **TDD con Pest PHP**.

---

## 🚀 Características Principales

* **Prevención de Solapamiento:** Algoritmo en base de datos que evita reservas dobles o sobrepuestas para un mismo proveedor en el mismo rango de tiempo.
* **Integración con Cloud Storage (AWS S3):** Gestión y subida de comprobantes de reserva directamente a Amazon Web Services (AWS S3) mediante el SDK de AWS.
* **Desarrollo Guiado por Pruebas (TDD):** Cobertura de pruebas unitarias y de integración (*Feature Tests*) escritas con **Pest PHP**.
* **Integración Continua (CI/CD):** Pipeline configurado con **GitHub Actions** para validar automáticamente la suite de pruebas y la integridad del código en cada `push` o `pull request`.
* **Autenticación API:** Protección de endpoints mediante tokens de acceso con **Laravel Sanctum**.

---

## 🛠️ Tech Stack & Arquitectura

* **Backend:** PHP 8.2+, Laravel 11.x, Sanctum.
* **Testing:** Pest PHP, PHPUnit, SQLite (`:memory:`).
* **Cloud & Filesystem:** AWS S3, Flysystem v3.
* **DevOps & CI/CD:** GitHub Actions, Git, WSL (Ubuntu).

---

## 🧪 Demostración de Cobertura de Pruebas (TDD)

El proyecto incluye dobles de prueba (*Fakes*) para el almacenamiento en S3 y bases de datos aisladas en memoria para garantizar ejecuciones ultrarrápidas en entonos locales y de CI.

```bash
php artisan test