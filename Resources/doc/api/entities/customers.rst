Customers
=========

GET /api/customers
------------------

Returns a list with customers.

Response
^^^^^^^^

An array with customers.

::
  [
  {
    "id": 1,
    "user": {},
    "name": "Customers name",
    "alias": "alias-for-customer",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/customers/:id
----------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of customer                   |
+------------+------------------------------------------+

Response
^^^^^^^^

A single customer.

::
  {
    "id": 1,
    "user": {},
    "name": "Customers name",
    "alias": "alias-for-customer",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

POST /api/customers
-------------------

::
  {
    "name": "Customers name",
    "alias": "alias-for-customer",
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| name       | Name of customer                         |
+------------+------------------------------------------+
| alias      | Alias for customer                       |
|            | * Unique for user                        |
|            | * Slug format (low-case, A-Z. a-z, 0-9)  |
|            | * Identifier for parser                  |
+------------+------------------------------------------+

Response
^^^^^^^^

The new created customer.

::
  {
    "id": 1,
    "user": {},
    "name": "Customers name",
    "alias": "alias-for-customer",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/customers/:id
----------------------

::
  {
    "user": ID,
    "name": "Customers name",
    "alias": "alias-for-customer",
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of customer                   |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified customer.

::
  {
    "id": 1,
    "user": {},
    "name": "Customers name",
    "alias": "alias-for-customer",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/customers/:id
-------------------------

Delete a customer by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of customer                   |
+------------+------------------------------------------+
