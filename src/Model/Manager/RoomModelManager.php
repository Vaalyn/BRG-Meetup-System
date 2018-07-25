<?php

namespace BronyRadioGermany\Meetup\Model\Manager;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\Room;
use BronyRadioGermany\Meetup\Model\RoomType;

class RoomModelManager {
	/**
	 * @param int $roomTypeId
	 * @param string $name
	 * @param int $bedCount
	 *
	 * @return \BronyRadioGermany\Meetup\Model\Room
	 */
	public function createRoom(int $roomTypeId, string $name, int $bedCount): Room {
		$this->validateRoomArguments($roomTypeId, $name, $bedCount);

		$room               = new Room();
		$room->room_type_id = $roomTypeId;
		$room->name         = $name;
		$room->bed_count    = $bedCount;
		$room->save();

		if ($room->room_id === null) {
			throw new InfoException('Zimmer konnte nicht erstellt werden');
		}

		return $room;
	}

	/**
	 * @param int $id
	 * @param int $roomTypeId
	 * @param string $name
	 * @param int $bedCount
	 *
	 * @return \BronyRadioGermany\Meetup\Model\Room
	 */
	public function updateRoom(int $id, int $roomTypeId, string $name, int $bedCount): Room {
		$this->validateRoomArguments($roomTypeId, $name, $bedCount);

		$room = Room::where('room_id', '=', $id)->first();

		if (!isset($room)) {
			throw new InfoException('Zimmer wurde nicht gefunden');
		}

		$room->room_type_id = $roomTypeId;
		$room->name         = $name;
		$room->bed_count    = $bedCount;
		$room->save();

		return $room;
	}

	/**
	 * @param int $roomTypeId
	 * @param string $name
	 * @param int $bedCount
	 *
	 * @return void
	 */
	public function validateRoomArguments(int $roomTypeId, string $name, int $bedCount): void {
		if (!RoomType::where('room_type_id', '=', $roomTypeId)->exists()) {
			throw new InfoException('Unbekannte Zimmerart');
		}

		if (trim($name) === '') {
			throw new InfoException('Es muss ein Name eingegeben werden');
		}

		if ($bedCount <= 0) {
			throw new InfoException('Es muss eine Bettenanzahl größer 0 eingegeben werden');
		}
	}
}
