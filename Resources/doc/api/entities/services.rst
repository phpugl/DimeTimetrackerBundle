Services
========

GET /api/services
-----------------

Returns a list with services.

+------------+------------------------------------------------------+
| Parameters                                                        |
+============+======================================================+
| count      | count=30  | Specify the limit of the service list.   |
+------------+------------------------------------------------------+
| page       | page=1    | Specify the offset of the service list.  |
+------------+------------------------------------------------------+
| filter     | filter[]= | Filter the service list.                 |
+------------+------------------------------------------------------+


Filter
^^^^^^

Filter the list of services by following parameters.

+------------+----------------------------------------------------------------------+
| Parameters                                                                        |
+============+======================================================================+
| user       | filter[user]=ID              | Filter by user id.                    |
+------------+----------------------------------------------------------------------+
| search     | filter[search]=TEXT          | Search for name and alias             |
+------------+----------------------------------------------------------------------+


Response
^^^^^^^^

An array with services.

::
  [
  {
    "id": 1,
    "user": {},
    "name": "service name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/services/:id
---------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of service                    |
+------------+------------------------------------------+

Response
^^^^^^^^

A single service.

::
  {
    "id": 1,
    "user": {},
    "name": "service name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

POST /api/services
------------------

::
  {
    "name": "services name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| name       | Name of service                          |
+------------+------------------------------------------+
| alias      | Alias for service                        |
|            | * Unique for user                        |
|            | * Slug format (low-case, A-Z. a-z, 0-9)  |
|            | * Identifier for parser                  |
+------------+------------------------------------------+

Response
^^^^^^^^

The new created service.

::
  {
    "id": 1,
    "user": {},
    "name": "services name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/services/:id
---------------------

::
  {
    "name": "services name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of service                    |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified service.

::
  {
    "id": 1,
    "user": {},
    "name": "services name",
    "alias": "alias-for-service",
    "description": "Service description",
    "rate": decimal
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/services/:id
------------------------

Delete a service by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of service                    |
+------------+------------------------------------------+
