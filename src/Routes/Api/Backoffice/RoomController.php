<?php

namespace BronyRadioGermany\Meetup\Routes\Api\Backoffice;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\Manager\RoomModelManager;
use BronyRadioGermany\Meetup\Model\Room;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RoomController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function saveRoomAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id            = $request->getParsedBody()['id'] ?? 0;
		$roomTypeId    = $request->getParsedBody()['room_type_id'] ?? 0;
		$name          = $request->getParsedBody()['name'] ?? '';
		$description   = $request->getParsedBody()['description'] ?? '';
		$bedCount      = $request->getParsedBody()['bed_count'] ?? 0;
		$price         = $request->getParsedBody()['price'] ?? 0;

		try {
			$roomModelManager = new RoomModelManager();

			if ($id > 0) {
				$roomModelManager->updateRoom($id, $roomTypeId, $name, $description, $bedCount, $price);

				return $response->write(json_encode(array(
					'status' => 'success',
					'message' => 'Zimmer wurde aktualisiert'
				)));
			}

			$roomModelManager->createRoom($roomTypeId, $name, $description, $bedCount, $price);

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Zimmer wurde hinzugefügt'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function deleteRoomAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$room = Room::where('room_id', '=', $id)->first();

		if (!isset($room)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Kein Zimmer gefunden'
			)));
		}

		if ($room->bookings(true)->count()) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Zimmer mit Buchungen oder Stornierungen können nicht gelöscht werden'
			)));
		}

		$room->forceDelete();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Zimmer wurde gelöscht'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getRoomAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$room = Room::where('room_id', '=', $id)->first();

		if (!isset($room)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Kein Zimmer gefunden'
			)));
		}

		return $response->write(json_encode(array(
			'status' => 'success',
			'result' => $room
		)));
	}
}
