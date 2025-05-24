<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

enum RequestStatus: int
{
    case REQUESTED = 0;
    case APPROVED = 1;
    case REJECTED = 2;
}
