Projects
========

GET /api/projects
-----------------

Returns a list with projects.

+------------+------------------------------------------------------+
| Parameters                                                        |
+============+======================================================+
| count      | count=30  | Specify the limit of the project list.   |
+------------+------------------------------------------------------+
| page       | page=1    | Specify the offset of the project list.  |
+------------+------------------------------------------------------+
| filter     | filter[]= | Filter the project list.                 |
+------------+------------------------------------------------------+


Filter
^^^^^^

Filter the list of projects by following parameters.

+------------+----------------------------------------------------------------------+
| Parameters                                                                        |
+============+======================================================================+
| user       | filter[user]=ID              | Filter by user id.                    |
+------------+----------------------------------------------------------------------+
| customer   | filter[customer]=ID          | Filter by customer id                 |
+------------+----------------------------------------------------------------------+
| search     | filter[search]=TEXT          | Search for name and alias             |
+------------+----------------------------------------------------------------------+

Response
^^^^^^^^

An array with projects.

::
  [
  {
    "id": 1,
    "user": {},
    "customers": {},
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/projects/:id
---------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of project                    |
+------------+------------------------------------------+

Response
^^^^^^^^

A single project.

::
  {
    "id": 1,
    "user": {},
    "customers": {},
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

POST /api/projects
------------------

::
  {
    "customers": ID,
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| name       | Name of project                          |
+------------+------------------------------------------+
| alias      | Alias for project                        |
|            | * Unique for user                        |
|            | * Slug format (low-case, A-Z. a-z, 0-9)  |
|            | * Identifier for parser                  |
+------------+------------------------------------------+

Response
^^^^^^^^

The new created project.

::
  {
    "id": 1,
    "user": {},
    "customers": {},
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/projects/:id
---------------------

::
  {
    "customers": ID,
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of project                    |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified project.

::
  {
    "id": 1,
    "user": {},
    "customers": {},
    "name": "projects name",
    "alias": "alias-for-project",
    "description": "Project description",
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "deadline": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "budgetPrice": int,
    "fixedPrice": int,
    "budgetTime": int,
    "rate": decimal,
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/projects/:id
------------------------

Delete a project by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of project                    |
+------------+------------------------------------------+
