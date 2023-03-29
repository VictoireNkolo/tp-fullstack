<?php

namespace TP\Building\Domain;

enum BuildingEventState
{
    case onDelete;
    case onSave;
}
