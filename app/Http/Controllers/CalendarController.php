<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use App\Transformers\CalendarTransformer;
use App\Transformers\CalendarEventTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CalendarController extends RestController
{
    protected $transformer_name = CalendarTransformer::class;

    /**
     * @SWG\Get(
     *     path="/calendars",
     *     tags={"Calendars"},
     *     operationId="calendarsIndex",
     *     summary="Fetch list of calendars.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="List of calendars."
     *     )
     * )
     *
     * @param CalendarService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CalendarService $service)
    {
        return $this->sendCollection($service->get());
    }

    /**
     * @SWG\Post(
     *     path="/calendars",
     *     tags={"Calendars"},
     *     operationId="calendarsStore",
     *     summary="Create a new calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateCalendarRequest")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created."
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     *
     * @param Request $request
     * @param CalendarService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CalendarService $service)
    {
        $this->validate($request, [
            'name' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'events' => 'required|array',
            'events.*.name' => 'required',
            'events.*.start' => 'required|date',
            'events.*.end' => 'sometimes|date',
            'events.*.attendanceTypeId' => 'required',
        ]);

        try {
            $calendar_data = [
                'name' => $request->input('name'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
            ];

            $events_data = collect($request->input('events'))
                ->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'start' => $item['start'],
                        'end' => isset($item['end']) ? $item['end'] : null,
                        'attendance_type_id' => $item['attendanceTypeId'],
                    ];
                })
                ->all();

            $calendar = $service->create($calendar_data, $events_data);

            return $this->sendItem($calendar, null, 201);
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/calendars/{id}",
     *     tags={"Calendars"},
     *     operationId="calendarsShow",
     *     summary="Fetch list of calendars.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A calendar."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(CalendarService $service, $id)
    {
        try {
            $calendar = $service->find($id);

            return $this->sendItem($calendar);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('calendar_not_found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/calendars/{id}",
     *     tags={"Calendars"},
     *     operationId="calendarsUpdate",
     *     summary="Update a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateCalendarRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated."
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error."
     *     ),
     * )
     *
     * @param CalendarService $service
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CalendarService $service, Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        try {
            $calendar = $service->update($id, [
                'name' => $request->input('name'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
            ]);

            return $this->sendItem($calendar);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/calendars/{id}",
     *     tags={"Calendars"},
     *     operationId="calendarsDestroy",
     *     summary="Delete a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CalendarService $service, $id)
    {
        try {
            $service->delete($id);

            return $this->response();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Get(
     *     path="/calendars/{id}/events",
     *     tags={"Calendars"},
     *     operationId="calendarsGetEvents",
     *     summary="Fetch list of events of a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Events list."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(CalendarService $service, $id)
    {
        try {
            $calendar = $service->find($id);

            return $this->sendCollection($calendar->events, CalendarEventTransformer::class);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Post(
     *     path="/calendars/{id}/events",
     *     tags={"Calendars"},
     *     operationId="calendarsEventStore",
     *     summary="Create a new event of a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateCalendarEventRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Created."
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param Request $request
     * @param [type] $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addEvent(CalendarService $service, Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'start' => 'required|date',
            'end' => 'sometimes|date',
            'attendanceTypeId' => 'required',
        ]);

        try {
            $calendar = $service->addEvent($id, [
                'name' => $request->input('name'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'attendance_type_id' => $request->input('attendanceTypeId'),
            ]);

            return $this->sendItem($calendar);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/calendars/{calendar_id}/events/{event_id}",
     *     tags={"Calendars"},
     *     operationId="calendarsEventUpdate",
     *     summary="Update an event of a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="calendar_id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="event_id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="params",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CreateCalendarEventRequest")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Created."
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param Request $request
     * @param $calendar_id
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEvent(CalendarService $service, Request $request, $calendar_id, $event_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'start' => 'required|date',
            'end' => 'sometimes|date',
            'attendanceTypeId' => 'required',
        ]);

        try {
            $calendar = $service->updateEvent($calendar_id, $event_id, [
                'name' => $request->input('name'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'attendance_type_id' => $request->input('attendanceTypeId'),
            ]);

            return $this->sendItem($calendar);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }

    /**
     * @SWG\Delete(
     *     path="/calendars/{calendar_id}/events/{event_id}",
     *     tags={"Calendars"},
     *     operationId="calendarsEventDestroy",
     *     summary="Delete a calendar.",
     *     security={{"basicAuth":{}}},
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="calendar_id",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         type="string",
     *         name="event_id",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Not found."
     *     )
     * )
     *
     * @param CalendarService $service
     * @param [type] $calendar_id
     * @param [type] $event_id
     * @return Illuminate\Http\JsonResponse
     */
    public function deleteEvent(CalendarService $service, $calendar_id, $event_id)
    {
        try {
            $service->deleteEvent($calendar_id, $event_id);

            return $this->response();
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Calendar/event not found');
        } catch (\Exception $e) {
            return $this->iseResponse($e->getMessage());
        }
    }
}
