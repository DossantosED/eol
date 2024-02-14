# REST API Expensas Online

## Instalación

    docker-compose up

## Base de datos

    ejecutar scripts.sql

# REST API


## Guardar el plan de suscripción de un cliente.

### Request

`POST /api/clientes/create`

    {
        "nombre_barrio_edificio" : "Recoleta",
        "plan_id" : 1,
        "email_contacto" : "recoleta@contacto.com",
        "tipo_cobro": "tarjeta"
    }

### Response

    Status: 201 Created
    Content-Type: application/json

    {
        "message": "Suscripción creada exitosamente"
    }

## Generar un lote de cobro.

### Request

`POST /api/lote/create`

### Response

    Status: 201 Created
    Content-Type: application/json

    {
        "message": "Lote creado exitosamente"
    }

## Consultar el detalle del lote.

### Request

`GET /api/lote/create/{detalle_id}`

### Response

    Status: 200 Ok
    Content-Type: application/json

    {
        "id": "1",
        "lote_id": "1",
        "cliente_id": "1",
        "monto": "10000.00",
        "estado_periodo_cobro": "enviado_a_cobrar"
    }

## Consultar el monto total y cantidad de cobros por lote.

### Request

`GET /api/loteDetalle/cantCobros/{lote_id}`

### Response

    Status: 200 Ok
    Content-Type: application/json

    {
        "cantidad de cobros": 1,
        "monto total": 17000
    }

## Consultar los datos de las suscripciones activas.

### Request

`GET /api/clientes/active`

### Response

    Status: 200 Ok
    Content-Type: application/json
    [
        {
            "id": "1",
            "nombre_barrio_edificio": "Recoleta",
            "email_contacto": "emanueldossantoset5@gmail.com",
            "tipo_cobro": "debito",
            "plan": {
                "nombre": "Básico",
                "costo_mensual": "10000.00"
            },
            "estado_suscripcion": "activa",
            "fecha_creacion": "2024-02-08 20:37:49"
        },
        {
            "id": "2",
            "nombre_barrio_edificio": "Palermo",
            "email_contacto": "palermo@gmail.com",
            "tipo_cobro": "tarjeta",
            "plan": {
                "nombre": "Pro",
                "costo_mensual": "25000.00"
            },
            "estado_suscripcion": "activa",
            "fecha_creacion": "2024-02-08 21:22:57"
        }
    ]

    ## Ejecutar Cron Job

    Linux
    0 0 5 * * /usr/bin/python3 /generar_lote.py
    Windows: crear tarea programada y agregar generar_lote.py
