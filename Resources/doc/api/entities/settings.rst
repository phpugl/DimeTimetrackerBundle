Settings
========

GET /api/settings
-----------------

Returns a list with settings.

+------------+------------------------------------------------------+
| Parameters                                                        |
+============+======================================================+
| count      | count=30  | Specify the limit of the setting list.   |
+------------+------------------------------------------------------+
| page       | page=1    |Specify the offset of the setting list.   |
+------------+------------------------------------------------------+
| filter     | filter[]= | Filter the setting list                  |
+------------+------------------------------------------------------+

Filter
^^^^^^

Filter the list of settings by following parameters.

+------------+----------------------------------------------------+
| Parameters                                                      |
+============+====================================================+
| user       | filter[user]=1              | Filter by user id.   |
+------------+----------------------------------------------------+
| namespace  | filter[namespace]=NAMESPACE | Filter by namespace  |
+------------+----------------------------------------------------+

Response
^^^^^^^^

An array with settings.

::
  [
  {
    "id": 1,
    "user": {},
    "key": "Setting key",
    "namespace": "Settings namespace",
    "value": "Setting value",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/settings/:id
---------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of setting                    |
+------------+------------------------------------------+

Response
^^^^^^^^

A single setting.

::
  {
    "id": 1,
    "user": {},
    "key": "Setting key",
    "namespace": "Settings namespace",
    "value": "Setting value",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

POST /api/settings
------------------

::
  {
    "key": "Setting key",
    "namespace": "Setting namespace",
    "value": "Setting value"
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| key        | Key of setting                           |
|            | * Unique for user and namespace          |
+------------+------------------------------------------+
| namespace  | Namespace for setting                    |
|            | * Unique for user                        |
+------------+------------------------------------------+
| value      | Value of setting                         |
|            | * Text                                   |
+------------+------------------------------------------+

Response
^^^^^^^^

The new created setting.

::
  {
    "id": 1,
    "user": {},
    "key": "Setting key",
    "namespace": "Setting namespace",
    "value": "Setting value",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/settings/:id
---------------------

::
  {
    "key": "Setting key",
    "namespace": "Setting namespace",
    "value": "Setting value"
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of setting                    |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified setting.

::
  {
    "id": 1,
    "user": {},
    "key": "Setting key",
    "namespace": "Setting namespace",
    "value": "Setting value",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/settings/:id
------------------------

Delete a setting by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of setting                    |
+------------+------------------------------------------+
