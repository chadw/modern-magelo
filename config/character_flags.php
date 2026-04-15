<?php

return [

    'flags' => [
        // planes of power
        'pop' => [
            'title' => 'Planes of Power',
            'steps' => [
                'pop_1' => [
                    'zone_flag' => 221,
                    'title' => 'Lair of Terris Thule (Plane of Nightmare B)',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_pon_hedge_jezith', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pon_construct', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 221],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_pon_hedge_jezith', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pon_construct', 'min' => 1],
                    ],
                ],
                'pop_2' => [
                    'zone_flag' => 214,
                    'title' => 'Drunder, Fortress of Zek (Plane of Tactics)',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 214],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poi_dragon', 'optional' => true],
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                    ],
                ],
                'pop_3' => [
                    'zone_flag' => 200,
                    'title' => 'Ruins of Lxanvom (Crypt of Decay)',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_pod_elder_fuirstel', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 200],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_pod_alder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_grimmus_planar_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_elder_fuirstel', 'min' => 1],
                    ],
                ],
                'pop_4' => [
                    'zone_flag' => 208,
                    'title' => 'Plane of Valor & Plane of Storms',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 208],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poj_mavuin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_tribunal', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                    ],
                ],
                'pop_5' => [
                    'zone_flag' => 211,
                    'title' => 'Halls of Honor',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pov_aerin_dar', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 211],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poj_mavuin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_tribunal', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pov_aerin_dar', 'min' => 1],
                    ],
                ],
                'pop_6' => [
                    'zone_flag' => 209,
                    'title' => 'Bastion of Thunder',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pos_askr_the_lost_final', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 209],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poj_mavuin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_tribunal', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pos_askr_the_lost', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pos_askr_the_lost_final', 'min' => 1],
                    ],
                ],
                'pop_7' => [
                    'zone_flag' => 220,
                    'title' => 'Temple of Marr',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pov_aerin_dar', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_faye', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_trell', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_garn', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 220],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poj_mavuin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_tribunal', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pov_aerin_dar', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_faye', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_trell', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_garn', 'min' => 1],
                    ],
                ],
                'pop_8' => [
                    'zone_flag' => 207,
                    'title' => 'Plane of Torment',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_pod_elder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_ponb_poxbourne', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_final', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 207],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_pod_alder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_grimmus_planar_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_elder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pon_hedge_jezith', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pon_construct', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_ponb_terris', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_ponb_poxbourne', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_bertox', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_final', 'min' => 1],
                    ],
                ],
                'pop_9' => [
                    'zone_flag' => 212,
                    'title' => 'Tower of Solusek Ro',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_tallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_vallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hohb_marr', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_saryrn_final', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 212],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_tallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_vallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_shadyglade', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_newleaf', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_saryrn', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_saryrn_final', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hohb_marr', 'min' => 1],
                    ],
                ],
                'pop_10' => [
                    'zone_flag' => 217,
                    'title' => 'Plane of Fire',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_tallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_vallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hohb_marr', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_ralloz', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_arlyxir', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_dresolik', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_jiva', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_rizlona', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_xuzl', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_solusk', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 217],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poi_behometh_flag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_tallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_vallon', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_ralloz', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_arlyxir', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_dresolik', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_jiva', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_rizlona', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_xuzl', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_sol_ro_solusk', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hohb_marr', 'min' => 1],
                    ]
                ],
                'pop_11' => [
                    'zone_flag' => 216,
                    'title' => 'Planes of Air, Earth and Water',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_elemental_grand_librarian', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 216],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_pon_hedge_jezith', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pon_construct', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_mavuin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_tribunal', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_poj_valor_storms', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_ponb_terris', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_ponb_poxbourne', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_alder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_grimmus_planar_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pod_elder_fuirstel', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pos_askr_the_lost', 'min' => 3],
                        ['type' => 'qg', 'key' => 'pop_pos_askr_the_lost_final', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_bot_agnarr', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pov_aerin_dar', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_faye', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_trell', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hoh_garn', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_hohb_marr', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_preflag', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_bertox', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_cod_final', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_shadyglade', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_saryrn', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_newleaf', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_pot_saryrn_final', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_tactics_ralloz', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_elemental_grand_librarian', 'min' => 1],
                    ],
                ],
                'pop_12' => [
                    'title' => 'Plane of Time',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'pop_time_maelin', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_fire_fennin_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_wind_xegony_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_water_coirnav_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_eartha_arbitor_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_earthb_rathe', 'min' => 1],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'pop_fire_fennin_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_wind_xegony_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_water_coirnav_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_eartha_arbitor_projection', 'min' => 1],
                        ['type' => 'qg', 'key' => 'pop_earthb_rathe', 'min' => 1],
                    ]
                ],
            ],
        ],

        // gates of discord
        'gates' => [
            'title' => 'Gates of Discord',
            'steps' => [
                'gates_1' => [
                    'title' => 'Vxed, The Crumbling Caverns',
                    'reqs' => [
                        ['type' => 'db', 'key' => '{character_id}-god-vxed-access', 'min' => 1],
                    ],
                    'pre' => [
                        ['type' => 'db', 'key' => '{character_id}-god-vxed-access', 'min' => 1],
                        ['type' => 'db', 'key' => '{character_id}-god_snplant', 'match' => [1,'T']],
                        ['type' => 'db', 'key' => '{character_id}-god_sncrematory', 'match' => [1,'T']],
                        ['type' => 'db', 'key' => '{character_id}-god_snlair', 'match' => [1,'T']],
                        ['type' => 'db', 'key' => '{character_id}-god_snpool', 'match' => [1,'T']],
                    ],
                ],
                'gates_2' => [
                    'title' => 'Tipt, Treacherous Crags',
                    'reqs' => [
                        ['type' => 'qg', 'key' => '{character_id}-god-tipt-access', 'min' => 1],
                    ],
                    'pre' => [
                        ['type' => 'db', 'key' => '{character_id}-god-tipt-access', 'min' => 1],
                    ],
                ],
                'gates_3' => [
                    'zone_flag' => 293,
                    'title' => 'Kod\'Taz, Broken Trial Grounds',
                    'reqs' => [
                        ['type' => 'qg', 'key' => '{character_id}-god-vxed-access', 'min' => 1],
                        ['type' => 'qg', 'key' => '{character_id}-god-tipt-access', 'min' => 1],
                        ['type' => 'qg', 'key' => '{character_id}-god-kodtaz-access', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 293],
                    ],
                    'pre' => [
                        ['type' => 'db', 'key' => '{character_id}-god-vxed-access', 'min' => 1],
                        ['type' => 'db', 'key' => '{character_id}-god-tipt-access', 'min' => 1],
                        ['type' => 'db', 'key' => '{character_id}-god-kodtaz-access', 'min' => 1],
                    ],
                ],
                'gates_4' => [
                    'optional' => true,
                    'title' => '(optional) Able to request the three raid trials',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'ikky', 'min' => 12],
                    ],
                    'pre' => collect(range(2, 12))->map(fn($i) => [
                        'type' => 'qg',
                        'key' => 'ikky',
                        'min' => $i,
                    ])->all(),
                ],
                'gates_5' => [
                    'title' => '(optional) Able to request Ikkinz: Chambers of Destruction',
                    'optional' => true,
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'ikky', 'min' => 14],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'ikky', 'min' => 13],
                        ['type' => 'qg', 'key' => 'ikky', 'min' => 14],
                    ],
                ],
                'gates_6' => [
                    'zone_flag' => 295,
                    'title' => 'Qvic, Prayer Grounds of Calling',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'god_qvic_access', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 295],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'god_qvic_access', 'min' => 1],
                    ],
                ],
                'gates_7' => [
                    'zone_flag' => 297,
                    'title' => 'Txevu, Lair of the Elite',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'god_txevu_access', 'min' => 1],
                        ['type' => 'zf', 'zone_id' => 297],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'god_txevu_access', 'min' => 1],
                    ],
                ],
            ],
        ],

        // omens of war
        'oow' => [
            'title' => 'Omens of War',
            'steps' => [
                'gates_1' => [
                    'title' => 'Muramite Proving Grounds Group Trials',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 63],
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 1],
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 2],
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 4],
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 8],
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 16],
                        ['type' => 'qg', 'key' => 'mpg_group_trials', 'min' => 32],
                    ],
                ],
                'gates_2' => [
                    'title' => 'The Citadel of Anguish',
                    'reqs' => [
                        ['type' => 'qg', 'key' => 'oow_mpg_raids_complete', 'min' => 1,],
                        ['type' => 'qg', 'key' => 'oow_rss_taromani_insignias', 'min' => 1,]
                    ],
                    'pre' => [
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 1],
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 2],
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 4],
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 8],
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 16],
                        ['type' => 'qg', 'key' => 'mpg_raid_trials', 'min' => 32],
                        ['type' => 'qg', 'key' => 'oow_rss_taromani_insignias', 'min' => 1],
                    ],
                ],
            ],
        ],
        /*
        ** Dragons of Norrath
        */
        /*
        'don' => [
            'title' => 'Dragons of Norrath',
            'steps' => [
                'don_1' => [
                    'zone_flag' => null,
                    'title' => 'Norrath Keepers (Good)',
                    'reqs' => [
                        ['key' => 268435455, 'value' => 'don_good'],
                    ],
                    'pre' => [
                        ['type' => 'db', 'key' => 1, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 2, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 4, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 8, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 16, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 32, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 64, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 128, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 256, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 512, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 1024, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 2048, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 4096, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 8192, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 16384, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 32768, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 65536, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 131072, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 262144, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 524288, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 1048576, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 2097152, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 4194304, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 8388608, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 16777216, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 33554432, 'value' => 'don_good'],
                        ['type' => 'db', 'key' => 67108864, 'value' => 'don_good'],
                    ],
                ],
                'don_2' => [
                    'zone_flag' => null,
                    'title' => 'Dark Reign (Evil)',
                    'reqs' => [
                        ['key' => 268435455, 'value' => 'don_evil'],
                    ],
                    'pre' => [
                        ['type' => 'db', 'key' => 1, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 2, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 4, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 8, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 16, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 32, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 64, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 128, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 256, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 512, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 1024, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 2048, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 4096, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 8192, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 16384, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 32768, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 65536, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 131072, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 262144, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 524288, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 1048576, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 2097152, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 4194304, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 8388608, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 16777216, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 33554432, 'value' => 'don_evil'],
                        ['type' => 'db', 'key' => 67108864, 'value' => 'don_evil'],
                    ],
                ],
            ],
        ],
        */
    ],

    'flag_description' => [
        /*
        ** Planes of Power
        */
        'pop_pon_construct_1'                 => 'You have killed the construct of nightmares in the Hedge event in the Plane of Nightmare.',
        'pop_pon_hedge_jezith_1'              => 'You have said \'Tortured by nightmares\' to Adroha Jezith, in the Plane of Tranquility sick bay.',
        'pop_poi_dragon_1'                    => '(optional) You have killed Xanamech Nezmirthafen and hailed Nitram Anizok in the Plane of Innovation.',
        'pop_poi_behometh_preflag_1'          => 'You have told Giwin Mirakon, \'I will test the machine\' within the Plane of Innovation factory.',
        'pop_poi_behometh_flag_1'             => 'You have defeated the Behemoth within Plane of Innovation and then QUICKLY hailed Giwin Mirakon in the factory.',
        'pop_pod_alder_fuirstel_1'            => 'You have talked to Adler Fuirstel outside of the Plane of Disease.',
        'pop_pod_grimmus_planar_projection_1' => 'You have defeated Grummus',
        'pop_pod_elder_fuirstel_1'            => 'You have talked to Elder Fuirstel in the plane of Tranquility sick bay.',
        'pop_poj_mavuin_1'                    => 'You have talked to Mavuin, and have agreed to plea his case to The Tribunal.',
        'pop_poj_tribunal_1'                  => 'You have showed the Tribunal the mark from the trail you have completed.',
        'pop_poj_valor_storms_1'              => 'You have returned to Mavuin, letting him know the tribunal will hear his case.',
        'pop_pov_aerin_dar_1'                 => 'You have defeated the prysmatic dragon, Aerin`Dar within the Plane of Valor.',
        'pop_pos_askr_the_lost_1'             => 'You have shown your prowess in battle to Askr, now you must make strides to get to the Bastion of Thunder.',
        'pop_pos_askr_the_lost_final_1'       => 'You have obtained the Talisman of Thunderous Foyer from Askr.',
        'pop_hoh_faye_1'                      => 'You have completed Trydan Faye\'s trial by defeating Rydda\'Dar.',
        'pop_hoh_trell_1'                     => 'You have completed Rhaliq Trell\'s trial by saving the villagers.',
        'pop_hoh_garn_1'                      => 'You have completed Alekson Garn\'s trial by protecting the maidens.',
        'pop_ponb_terris_1'                   => 'You have killed Terris Thule.',
        'pop_ponb_poxbourne_1'                => 'You have hailed Elder Poxbourne in the Plane of Tranquility after defeating Terris Thule.',
        'pop_cod_preflag_1'                   => 'You have completed the Carpryn cycle within Ruins of Lxanvom.',
        'pop_cod_bertox_1'                    => 'You have killed Bertox within the Crypt of Decay.',
        'pop_cod_final_1'                     => 'You have hailed Elder Fuirstel in the Plane of Tranquility after defeating Bertox.',
        'pop_tactics_tallon_1'                => 'You have killed Tallon Zek.',
        'pop_tactics_vallon_1'                => 'You have killed Vallon Zek.',
        'pop_pot_saryrn_final_1'              => 'You have hailed Fahlia Shadyglade after defeating The Keeper of Sorrows and Saryrn.',
        'pop_pot_saryrn_1'                    => 'You have killed Saryrn.',
        'pop_hohb_marr_1'                     => 'You have defeated Lord Mithaniel Marr within his temple.',
        'pop_pot_newleaf_1'                   => 'You have killed The Keeper of Sorrows.',
        'pop_tactics_ralloz_1'                => 'You have killed Ralloz Zek the Warlord.',
        'pop_sol_ro_arlyxir_1'                => 'You have defeated Arlyxir within the Tower of Solusk Ro.',
        'pop_sol_ro_dresolik_1'               => 'You have defeated The Protector of Dresolik within the Tower of Solusk Ro.',
        'pop_sol_ro_jiva_1'                   => 'You have defeated Jiva within the Tower of Solusk Ro.',
        'pop_sol_ro_rizlona_1'                => 'You have defeated Rizlona within the Tower of Solusk Ro.',
        'pop_sol_ro_xuzl_1'                   => 'You have defeated Xuzl within the Tower of Solusk Ro.',
        'pop_sol_ro_solusk_1'                 => 'You have defeated Soluesk Ro within his own tower.',
        'pop_bot_agnarr_1'                    => 'You have defeated Agnarr, the Storm Lord.',
        'pop_pot_shadyglade_1'                => 'You have said \'I will go\' to Fahlia Shadyglade in the Plane of Tranquility',
        'pop_elemental_grand_librarian_1'     => 'You have spoken with the grand librarian to receive access to the Elemental Planes.',
        'pop_fire_fennin_projection_1'        => 'You have defeated Fennin Ro, the Tyrant of Fire.',
        'pop_wind_xegony_projection_1'        => 'You have defeated Xegony, the Queen of Air.',
        'pop_water_coirnav_projection_1'      => 'You have defeated Coirnav, the Avatar of Water.',
        'pop_eartha_arbitor_projection_1'     => 'You have defeated the arbitor within Plane of Earth A.',
        'pop_earthb_rathe_1'                  => 'You have defeated the Rathe Council within Plane of Earth B',
        /*
        ** Gates of Discord
        */
        'god_snplant_1'                     => 'You have completed the Purifying Plant trial!',
        'god_sncrematory_1'                 => 'You have completed the Crematory trial!',
        'god_snlair_1'                      => 'You have completed the Lair of Trapped Ones trial!',
        'god_snpool_1'                      => 'You have completed the Pool of Sludge trial!',
        'god_snplant_T'                     => 'You have completed the Purifying Plant trial OUT OF ORDER! Talk to the scribe to fix it!',
        'god_sncrematory_T'                 => 'You have completed the Crematory trial OUT OF ORDER! Talk to the scribe to fix it!',
        'god_snlair_T'                      => 'You have completed the Lair of Trapped Ones trial OUT OF ORDER! Talk to the scribe to fix it!',
        'god_snpool_T'                      => 'You have completed the Pool of Sludge trial OUT OF ORDER! Talk to the scribe to fix it!',
        'god-vxed-access_1'                 => 'You have completed the 4 sewer trials or defeated Smith Rondo!',
        'god-tipt-access_1'                 => 'You have hailed Stonespiritist Ekikoa in Vxed!',
        'god-kodtaz-access_1'               => 'You have hailed Master Stonespiritist Okkanu in Tipt!',
        'ikky_2'                            => 'You have completed the trial at the Temple of Singular Might!',
        'ikky_3'                            => 'You have completed the trial at the Temple of Twin Struggles!',
        'ikky_4'                            => 'You have completed the trial at the Temple of the Tri-Fates!',
        'ikky_5'                            => 'You\'ve returned four relics from the Martyrs Passage!',
        'ikky_6'                            => 'You\'ve recovered important glyphs from the Temple of the Damned!',
        'ikky_7'                            => 'You\'ve successfully translated the glyphs you found in the Temple of the Damned!',
        'ikky_8'                            => 'You\'ve recovered the four flesh scraps from the small temple south of the summoners!',
        'ikky_9'                            => 'You\'ve sewn the flesh scraps together to make the Sewn Flesh Parchment!',
        'ikky_10'                           => 'You\'ve found the three clues from the three trial temples!',
        'ikky_11'                           => 'You\'ve collected the Minor Relics of Power from the Pit of the Lost!',
        'ikky_12'                           => 'You\'ve rescued the artifact from the Ageless Relic Protector in the Pit of the Lost!',
        'ikky_13'                           => 'You have completed the three raid trials!',
        'ikky_14'                           => 'You have crafted the Icon of the Altar!',
        'god_qvic_access_1'                 => 'You have given the Sliver of the High Temple to Tublik Narwethar after defeating Vrex Barxt Qurat in Uqua.',
        'god_txevu_access_1'                => 'You have given the three pieces of the high temple to Brevik Kalaner.',
        /*
        ** Omens of War
        */
        'mpg_group_trials_1'                => 'You have completed The Mastery of Fear trial.',
        'mpg_group_trials_2'                => 'You have completed The Mastery of Ingenuity trial.',
        'mpg_group_trials_4'                => 'You have completed The Mastery of Weaponry trial.',
        'mpg_group_trials_8'                => 'You have completed The Mastery of Subversion trial.',
        'mpg_group_trials_16'               => 'You have completed The Mastery of Efficiency trial.',
        'mpg_group_trials_32'               => 'You have completed The Mastery of Destruction trial.',
        'mpg_raid_trials_1'                 => 'You have completed The Mastery of Hate trial.',
        'mpg_raid_trials_2'                 => 'You have completed The Mastery of Endurance trial.',
        'mpg_raid_trials_4'                 => 'You have completed The Mastery of Foresight trial.',
        'mpg_raid_trials_8'                 => 'You have completed The Mastery of Specialization trial.',
        'mpg_raid_trials_16'                => 'You have completed The Mastery of Adaptation trial.',
        'mpg_raid_trials_32'                => 'You have completed The Mastery of Corruption trial.',
        'oow_rss_taromani_insignias_1'      => 'You have turned the seven signets into Taromani.',
        /*
        ** Dragons of Norrath
        */

    ],
];
