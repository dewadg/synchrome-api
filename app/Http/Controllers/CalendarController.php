<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use App\Transformers\CalendarTransformer;
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
     * Undocumented function
     *
     * @param Request $request
     * @param CalendarService $service
     * @return void
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
}
