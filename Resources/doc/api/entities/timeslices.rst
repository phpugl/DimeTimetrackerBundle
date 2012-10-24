Timeslices
==========

GET /api/timeslices
-------------------

Returns a list with timeslices.

+------------+-------------------------------------------------------+
| Parameters                                                         |
+============+=======================================================+
| count      | count=30  | Specify the limit of the timeslice list.  |
+------------+-------------------------------------------------------+
| page       | page=1    | Specify the offset of the timeslice list. |
+------------+-------------------------------------------------------+
| filter     | filter[]= | Filter the timeslice list.                |
+------------+-------------------------------------------------------+


Filter
^^^^^^

Filter the list of timeslices by following parameters.

+------------+----------------------------------------------------------------------+
| Parameters                                                                        |
+============+======================================================================+
| activity   | filter[activity]=ID          | Filter by activity id                 |
+------------+----------------------------------------------------------------------+
| date       | filter[date]=YYYY-MM-DD      | Filter by date                        |
|            |                              | * single date with YYYY-MM-DD format  |
|            | filter[date][]=YYYY-MM-DD    | * array with to entry for range       |
|            |                              |                                       |
+------------+----------------------------------------------------------------------+

Response
^^^^^^^^

An array with timeslices.

::
  [
  {
    "id": 1,
    "activity": {},
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }
  ]


GET /api/timeslices/:id
-----------------------

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of timeslice                  |
+------------+------------------------------------------+

Response
^^^^^^^^

A single timeslice.

::
  {
    "id": 1,
    "activity": {},
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

POST /api/timeslices
--------------------

::
  {
    "activity": ID,
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

+------------+--------------------------------------------------+
| Parameters                                                    |
+============+==================================================+
| name       | Name of timeslice                                |
+------------+--------------------------------------------------+
| duration   | Duration is an integer                           |
|            | * Seconds is the base                            |
|            | * Default is "0"                                 |
|            | * Auto-calculated when only start and stop given |
+------------+--------------------------------------------------+

Response
^^^^^^^^

The new created timeslice.

::
  {
    "id": 1,
    "activity": {},
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

PUT /api/timeslices/:id
-----------------------

::
  {
    "activity": ID,
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of timeslice                  |
+------------+------------------------------------------+

Response
^^^^^^^^

The modified timeslice.

::
  {
    "id": 1,
    "activity": {},
    "duration": int,
    "startedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "stoppedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "createdAt": "DATETIME (YYYY-MM-DD HH:mm:ss)",
    "updatedAt": "DATETIME (YYYY-MM-DD HH:mm:ss)"
  }

DELETE /api/timeslices/:id
--------------------------

Delete a timeslice by the given ID.

+------------+------------------------------------------+
| Parameters                                            |
+============+==========================================+
| id         | Identifier of timeslice                  |
+------------+------------------------------------------+
