Activities
==========

GET /api/activities
-------------------

Returns a list with activities.

+------------+------------------------------------------------------+
| Parameters                                                        |
+============+======================================================+
| count      | count=30  | Specify the limit of the activity list.  |
+------------+------------------------------------------------------+
| page       | page=1    | Specify the offset of the activity list. |
+------------+------------------------------------------------------+
| filter     | filter[]= | Filter the activity list.                |
+------------+------------------------------------------------------+


Filter
^^^^^^

Filter the list of activities by following parameters.

+------------+----------------------------------------------------------------------+
| Parameters                                                                        |
+============+======================================================================+
| user       | filter[user]=ID              | Filter by user id.                    |
+------------+----------------------------------------------------------------------+
| customer   | filter[customer]=ID          | Filter by customer id                 |
+------------+----------------------------------------------------------------------+
| project    | filter[project]=ID           | Filter by project id                  |
+------------+----------------------------------------------------------------------+
| service    | filter[service]=ID           | Filter by service id                  |
+------------+----------------------------------------------------------------------+
| active     | filter[active]=true|false    | Filter by active / running timeslice  |
+------------+----------------------------------------------------------------------+
| date       | filter[date]=YYYY-MM-DD      | Filter by date                        |
|            |                              | * single date with YYYY-MM-DD format  |
|            | filter[date][]=YYYY-MM-DD    | * array with to entry for range       |
|            |                              |                                       |
+------------+----------------------------------------------------------------------+

Response
^^^^^^^^

An array with activities.

::
  [
  {
    "id": 1,
    "user": {},
    "customer": {},
    "project": {},
    "service": {},
    "timeslices": [],
    "description": "Activity description",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/activities/:id
-----------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of activity                   |
+------------+------------------------------------------+

Response
^^^^^^^^

A single activity.

::
  {
    "id": 1,
    "user": {},
    "customer": {},
    "project": {},
    "service": {},
    "timeslices": [],
    "description": "Activity description",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PULL /api/activities
--------------------

::
  {
    "user": ID,
    "customer": ID,
    "project": ID,
    "service": ID,
    "timeslices": [??],
    "description": "Activity description",
  }

or

::
  {
    "parse": "Text with a certain structure which should be parsed."
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| parse      | Text will be processed by controller.    |
+------------+------------------------------------------+

Response
^^^^^^^^

The new created activity.

::
  {
    "id": 1,
    "user": {},
    "customer": {},
    "project": {},
    "service": {},
    "timeslices": [],
    "description": "Activity description",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/activities/:id
-----------------------

::
  {
    "user": ID,
    "customer": ID,
    "project": ID,
    "service": ID,
    "timeslices": [??],
    "description": "Activity description",
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of activity                   |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified activity.

::
  {
    "id": 1,
    "user": {},
    "customer": {},
    "project": {},
    "service": {},
    "timeslices": [],
    "description": "Activity description",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/activities/:id
--------------------------

Delete a activity by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of activity                   |
+------------+------------------------------------------+
