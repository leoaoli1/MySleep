var MAXSPRITES = 100;
var MAXBITMAPS = 1e3;
var PSY_CENTRAL = -99999;
var MAX_FONTS = 100;
var psy_font_number = 0;
var psy_fonts = new Array;
var psy_fonts_size = new Array;
var PSY_VIDEO_DOUBLEBUFFER = 1;
var PSY_KEY_STATUS_CORRECT = 1;
var PSY_KEY_STATUS_WRONG = 2;
var PSY_KEY_STATUS_TIMEOUT = 3;
var psy_screen_center_x = 0;
var psy_screen_x_offset = 0;
var psy_screen_center_y = 0;
var psy_screen_y_offset = 0;
var psy_screen_width = 800;
var psy_screen_height = 600;
var psy_exp_start_time = 0;
var psy_exp_current_time = 0;
var psy_blockorder = 1;
var tablerow = 0;
var keystatus = {
    key: 0,
    status: 0,
    time: 0,
    totaltime: 0,
    mouse_x: 0,
    mouse_y: 0
};
var possiblekeys = new Array;
var mousestatus = {
    key: 0,
    status: 0,
    time: 0,
    totaltime: 0,
    x: 0,
    y: 0
};
var c = document.getElementById("exp");
var canvas_x_offset = c.getBoundingClientRect().left;
var canvas_y_offset = c.getBoundingClientRect().top;
var ctx = c.getContext("2d");
var log = document.getElementById("log");
var output = document.getElementById("Output");
outputdata = String();
var psy_bitmaps = new Array;
var bmp_number = 0;
var psy_sounds = new Array;
var psy_sound_number = 0;

function psy_load_bitmap(name) {
    psy_bitmaps[bmp_number] = new Image;
    psy_bitmaps[bmp_number].src = name;
    bmp_number++;
    return bmp_number - 1
}

function psy_load_sound(name) {
    psy_sounds[psy_sound_number] = new Audio;
    psy_sounds[psy_sound_number].src = name;
    psy_sound_number++;
    return psy_sound_number - 1
}

function psy_play(sound) {
    psy_sounds[sound - 1].play()
}

function psy_silence(sound) {
    psy_sounds[sound - 1].pause();
    psy_sounds[sound - 1].currentTime = 0
}

function psy_load_font(name, size) {
    psy_fonts[psy_font_number] = size + "pt " + name;
    psy_fonts_size[psy_font_number] = size;
    psy_font_number++;
    return psy_font_number - 1
}

function addlog(text) {
    if (log != null) {
        log.value += text + "\n";
        log.scrollTop = log.scrollHeight
    }
}

function addoutput(text) {
    if (output != null) output.value += text + "\n";
    outputdata = outputdata + text + "\n"
}

function hexrgb(r, g, b) {
    h = "#";
    if (r < 16) h = h + "0" + r.toString(16);
    else h = h + r.toString(16);
    if (g < 16) h = h + "0" + g.toString(16);
    else h = h + g.toString(16);
    if (b < 16) h = h + "0" + b.toString(16);
    else h = h + b.toString(16);
    return h
}
starttime = 0;

function psy_expect_keyboard() {
    psy_readkey.expect_keyboard = true;
    window.addEventListener("keydown", getkeydown, true);
    window.addEventListener("keyup", getkeyup, true);
    psy_readkey.keyupeventlistener = true;
    psy_readkey.keydowneventlistener = true
}

function psy_expect_mouse() {
    psy_readkey.expect_mouse = true
}

function psy_keyboard(possiblekeys, nkeys, correctkey, maxtime) {
    psy_readkey.expectedkey = possiblekeys[correctkey];
    psy_readkey.keys = possiblekeys;
    psy_expect_keyboard();
    psy_readkey.start(current_task, maxtime)
}
var psy_readkey = {
    lasttask: "",
    starttime: 0,
    readkeytimer: "",
    rt: 0,
    key: 0,
    status: 0,
    keys: [],
    expect_keyboard: false,
    expect_mouse: false,
    expectedkey: 0,
    bitmap: 0,
    bitmap_range: [-1, -1],
    mouseovereventlistener: false,
    mousedowneventlistener: false,
    keyupeventlistener: false,
    keydowneventlistener: false,
    start: function (task, maxtime) {
        psy_readkey.rt = maxtime;
        psy_readkey.key = 0;
        psy_readkey.starttime = (new Date).getTime();
        psy_readkey.lasttask = task;
        psy_readkey.readkeytimer = setTimeout("psy_readkey.timeout()", maxtime);
        keystatus.status = 3;
        keystatus.time = maxtime;
        keystatus.key = 0
    },
    stop: function () {
        clearTimeout(psy_readkey.readkeytimer);
        psy_readkey.expect_keyboard = false;
        psy_readkey.expect_mouse = false;
        if (psy_readkey.mouseovereventlistener == true) {
            window.removeEventListener("mousemove", getmouse_in_area, false);
            psy_readkey.mouseovereventlistener = false
        }
        if (psy_readkey.mousedowneventlistener == true) {
            window.removeEventListener("mousedown", getmouseclick_in_area, false);
            psy_readkey.mousedowneventlistener = false
        }
        if (psy_readkey.keyupeventlistener == true) {
            window.removeEventListener("keyup", getkeyup, false);
            psy_readkey.keyupeventlistener = false
        }
        if (psy_readkey.keydowneventlistener == true) {
            window.removeEventListener("keydown", getkeydown, false);
            psy_readkey.keydowneventlistener = false
        }
        eval(psy_readkey.lasttask + ".run()")
    },
    timeout: function () {
        psy_readkey.expect_keyboard = false;
        psy_readkey.expect_mouse = false;
        if (psy_readkey.mouseovereventlistener == true) {
            window.removeEventListener("mousemove", getmouse_in_area, false);
            psy_readkey.mouseovereventlistener = false
        }
        if (psy_readkey.mousedowneventlistener == true) {
            window.removeEventListener("mousedown", getmouseclick_in_area, false);
            psy_readkey.mousedowneventlistener = false
        }
        eval(psy_readkey.lasttask + ".run()")
    }
};
var inkeypress = 0;

function getkeydown(e) {
    inkeypress++;
    if (psy_readkey.expect_keyboard == true && inkeypress == 1 && psy_readkey.keys.indexOf(e.keyCode) > -1) {
        keystatus.time = (new Date).getTime() - psy_readkey.starttime;
        keystatus.key = e.keyCode;
        if (e.keyCode == psy_readkey.expectedkey) {
            keystatus.status = 1
        } else {
            keystatus.status = 2
        }
        psy_readkey.expect_keyboard = false;
        psy_readkey.stop()
    } else {
        inkeypress = 0
    }
}

function getkeyup(e) {
    if (inkeypress == 1) {
        keystatus.totaltime = (new Date).getTime() - psy_readkey.starttime
    }
    inkeypress = 0
}

function getmouse_in_area(e) {
    if (psy_readkey.expect_mouse == true) {
        canvas_x_offset = c.getBoundingClientRect().left;
        canvas_y_offset = c.getBoundingClientRect().top;
        tmpmouseX = e.clientX - canvas_x_offset;
        tmpmouseY = e.clientY - canvas_y_offset;
        if (tmpmouseX >= psy_stimuli1[psy_readkey.bitmap - 1].rect.x && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.width && tmpmouseY >= psy_stimuli1[psy_readkey.bitmap - 1].rect.y && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.height) {
            keystatus.time = (new Date).getTime() - psy_readkey.starttime;
            keystatus.status = 1;
            keystatus.mouse_x = tmpmouseX - psy_screen_x_offset;
            keystatus.mouse_y = tmpmouseY - psy_screen_y_offset;
            psy_readkey.expect_mouse = false;
            psy_readkey.stop()
        }
    }
}

function getmouseclick_in_area(e) {
    if (psy_readkey.expect_mouse == true && psy_readkey.bitmap_range[1] == -1) {
        keystatus.time = (new Date).getTime() - psy_readkey.starttime;
        canvas_x_offset = c.getBoundingClientRect().left;
        canvas_y_offset = c.getBoundingClientRect().top;
        tmpmouseX = e.clientX - canvas_x_offset;
        tmpmouseY = e.clientY - canvas_y_offset;
        var correctbitmapclicked = false;
        if (tmpmouseX >= psy_stimuli1[psy_readkey.bitmap - 1].rect.x && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.width && tmpmouseY >= psy_stimuli1[psy_readkey.bitmap - 1].rect.y && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.height) {
            correctbitmapclicked = true
        }
        if (psy_readkey.expectedkey == e.button && correctbitmapclicked == true) keystatus.status = 1;
        else keystatus.status = 2;
        keystatus.mouse_x = tmpmouseX - psy_screen_x_offset;
        keystatus.mouse_y = tmpmouseY - psy_screen_y_offset;
        psy_readkey.expect_mouse = false;
        psy_readkey.stop()
    }
    if (psy_readkey.expect_mouse == true && psy_readkey.bitmap_range[0] > -1) {
        keystatus.time = (new Date).getTime() - psy_readkey.starttime;
        canvas_x_offset = c.getBoundingClientRect().left;
        canvas_y_offset = c.getBoundingClientRect().top;
        tmpmouseX = e.clientX - canvas_x_offset;
        tmpmouseY = e.clientY - canvas_y_offset;
        var tmpbitmap = psy_bitmap_under_mouse(0, psy_readkey.bitmap_range[0], psy_readkey.bitmap_range[1], tmpmouseX - psy_screen_x_offset, tmpmouseY - psy_screen_y_offset);
        if (tmpbitmap >= psy_readkey.bitmap_range[0] && tmpbitmap <= psy_readkey.bitmap_range[1]) {
            var correctbitmapclicked = false;
            if (tmpmouseX >= psy_stimuli1[psy_readkey.bitmap - 1].rect.x && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.width && tmpmouseY >= psy_stimuli1[psy_readkey.bitmap - 1].rect.y && tmpmouseX <= psy_stimuli1[psy_readkey.bitmap - 1].rect.x + psy_stimuli1[psy_readkey.bitmap - 1].rect.height) {
                correctbitmapclicked = true
            }
            if (psy_readkey.expectedkey == e.button && correctbitmapclicked == true) keystatus.status = 1;
            else keystatus.status = 2;
            keystatus.mouse_x = tmpmouseX - psy_screen_x_offset;
            keystatus.mouse_y = tmpmouseY - psy_screen_y_offset;
            psy_readkey.expect_mouse = false;
            psy_readkey.bitmap_range = [-1, -1];
            psy_readkey.stop()
        }
    }
}

function psy_mouse_in_bitmap_rectangle(bitmap, maxwait) {
    psy_readkey.bitmap = bitmap;
    window.addEventListener("mousemove", getmouse_in_area, false);
    psy_readkey.mouseovereventlistener = true;
    psy_expect_mouse();
    psy_readkey.start(current_task, maxwait)
}

function psy_mouse_click_bitmap_rectangle(mousebutton, bitmap, maxwait) {
    psy_readkey.bitmap = bitmap;
    if (mousebutton == "l") {
        psy_readkey.expectedkey = 0
    } else {
        psy_readkey.expectedkey = 1
    }
    window.addEventListener("mousedown", getmouseclick_in_area, false);
    psy_readkey.mousedowneventlistener = true;
    psy_expect_mouse();
    psy_readkey.start(current_task, maxwait)
}

function psy_mouse_click_bitmap_rectangle_range(mousebutton, bitmap, maxwait, first, last) {
    psy_readkey.bitmap = bitmap;
    if (mousebutton == "l") {
        psy_readkey.expectedkey = 0
    } else {
        psy_readkey.expectedkey = 1
    }
    window.addEventListener("mousedown", getmouseclick_in_area, false);
    psy_readkey.mousedowneventlistener = true;
    psy_readkey.bitmap_range = [first, last];
    psy_expect_mouse();
    psy_readkey.start(current_task, maxwait)
}

function psy_bitmap_under_mouse(searchdirection, first, last, x, y) {
    var i = 0;
    var j = 0;
    var tmp = 0;
    var found_bitmap = -1;
    var allchecked = 1;
    i = 0;
    j = psy_stimuli1_n;
    if (first > -1) i = first - 1;
    if (last > -1) j = last - 1;
    if (searchdirection == 0 && i > j) {
        tmp = j;
        j = i;
        i = tmp
    }
    if (searchdirection == 1 && i < j) {
        tmp = j;
        j = i;
        i = tmp
    }
    while (allchecked == 1 && found_bitmap == -1) {
        if (x + psy_screen_x_offset >= psy_stimuli1[i].rect.x && x + psy_screen_x_offset <= psy_stimuli1[i].rect.x + psy_stimuli1[i].rect.width && y + psy_screen_y_offset >= psy_stimuli1[i].rect.y && y + psy_screen_y_offset <= psy_stimuli1[i].rect.y + psy_stimuli1[i].rect.height) {
            found_bitmap = i
        } else {}
        if (searchdirection == 0 && found_bitmap == -1) {
            if (i >= j) allchecked = 0;
            i++
        }
        if (searchdirection == 1 && found_bitmap == -1) {
            if (i <= j) allchecked = 0;
            i--
        }
    }
    return found_bitmap + 1
}

function psy_wait(stimulus, key) {
    if (stimulus != 0) {
        psy_clear_stimulus_counters_db();
        psy_add_centered_bitmap_db(stimulus, PSY_CENTRAL, PSY_CENTRAL);
        psy_draw_all_db()
    }
    psy_readkey.expectedkey = key;
    psy_readkey.keys = [key];
    psy_expect_keyboard();
    psy_readkey.start(current_block, 99999999)
}
var psy_pager = {
    original_block: "",
    current_bitmap_in_pager: 0,
    bitmaps: [],
    n: 0,
    start: function (bitmaps) {
        psy_pager.original_block = current_block;
        psy_pager.n = bitmaps.length;
        psy_pager.bitmaps = bitmaps;
        current_block = "psy_pager";
        psy_pager.current_bitmap_in_pager = 0;
        keystatus.key = -1;
        psy_pager.run()
    },
    run: function () {
        if ((keystatus.key == 32 || keystatus.key == 40) && psy_pager.current_bitmap_in_pager < psy_pager.n - 1) psy_pager.current_bitmap_in_pager++;
        if (keystatus.key == 38 && psy_pager.current_bitmap_in_pager > 0) psy_pager.current_bitmap_in_pager--;
        if (keystatus.key == 81) {
            current_block = psy_pager.original_block;
            psy_clear_screen_db();
            setTimeout(current_block + ".run()", 10)
        } else {
            psy_clear_stimulus_counters_db();
            psy_add_centered_bitmap_db(psy_pager.bitmaps[psy_pager.current_bitmap_in_pager], PSY_CENTRAL, PSY_CENTRAL);
            psy_draw_all_db();
            psy_readkey.expectedkey = 32;
            psy_readkey.keys = [32, 40, 38, 81];
            psy_expect_keyboard();
            psy_readkey.start(current_block, 99999999)
        }
    }
};

function psy_add_text_rgb_db(fontno, x, y, centerx, centery, r, g, b, text, align) {
    var xpos = 0,
        ypos = 0,
        width = 0,
        height = 0;
    psy_stimuli1[psy_stimuli1_end].x = x;
    psy_stimuli1[psy_stimuli1_end].y = y;
    psy_stimuli1[psy_stimuli1_end].type = 2;
    psy_stimuli1[psy_stimuli1_end].on = 1;
    ctx.font = psy_fonts[fontno];
    tmpsize = ctx.measureText(text);
    height = psy_fonts_size[fontno];
    width = tmpsize.width;
    tmpgraphicsCanvas = document.createElement("canvas");
    tmpgraphicsCanvas.width = width;
    tmpgraphicsCanvas.height = Math.round(height * 1.3);
    tmpgraphics = tmpgraphicsCanvas.getContext("2d");
    tmpgraphics.fillStyle = "#000000";
    tmpgraphics.fillRect(0, 0, width, height);
    tmpgraphics.fillStyle = hexrgb(r, g, b);
    tmpgraphics.font = psy_fonts[fontno];
    tmpgraphics.fillText(text, 0, height);
    psy_stimuli1[psy_stimuli1_end].text = tmpgraphicsCanvas;
    xpos = x;
    ypos = y;
    if (align == 0) {
        if (x == PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = psy_screen_center_x - width / 2;
        if (x != PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = x + psy_screen_x_offset - width / 2;
        if (y == PSY_CENTRAL && centery == PSY_CENTRAL) ypos = psy_screen_center_y - height / 2;
        if (y != PSY_CENTRAL && centery == PSY_CENTRAL) ypos = y + psy_screen_y_offset - height / 2
    }
    if (align == 1) {
        if (x == PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = psy_screen_center_x;
        if (x != PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = x + psy_screen_x_offset;
        if (y == PSY_CENTRAL && centery == PSY_CENTRAL) ypos = psy_screen_center_y - height / 2;
        if (y != PSY_CENTRAL && centery == PSY_CENTRAL) ypos = y + psy_screen_y_offset - height / 2
    }
    if (align == 2) {
        if (x == PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = psy_screen_center_x - width;
        if (x != PSY_CENTRAL && centerx == PSY_CENTRAL) xpos = x + psy_screen_x_offset - width;
        if (y == PSY_CENTRAL && centery == PSY_CENTRAL) ypos = psy_screen_center_y - height / 2;
        if (y != PSY_CENTRAL && centery == PSY_CENTRAL) ypos = y + psy_screen_y_offset - height / 2
    }
    if (xpos < 0) xpos = 0;
    if (ypos < 0) ypos = 0;
    if (xpos > psy_screen_width) xpos = psy_screen_width - width;
    if (ypos > psy_screen_height) ypos = psy_screen_height - height;
    psy_stimuli1[psy_stimuli1_end].rect.x = xpos;
    psy_stimuli1[psy_stimuli1_end].rect.y = ypos;
    psy_stimuli1[psy_stimuli1_end].rect.width = width;
    psy_stimuli1[psy_stimuli1_end].rect.height = height;
    psy_stimuli1_n++;
    psy_stimuli1_end++;
    return psy_stimuli1_end
}

function psy_clear_screen_db() {
    psy_clear_stimulus_counters_db();
    psy_draw_all_db()
}

function psy_clear_stimuli1(number) {
    var tmp;
    if (number < 0) tmp = psy_stimuli1_end + number;
    else tmp = number - 1;
    if (psy_stimuli1[tmp].on != 0) {
        psy_stimuli1[tmp].on = 0;
        psy_stimuli1_n--
    }
}

function psy_unhide_stimuli1(number) {
    var tmp;
    if (number < 0) tmp = psy_stimuli1_end + number;
    else tmp = number - 1;
    if (psy_stimuli1[tmp].on != 1) {
        psy_stimuli1[tmp].on = 1;
        psy_stimuli1_n++
    }
}

function psy_clear_range_db(low, high) {
    var x = 0;
    var i = low;
    var j = high;
    if (low > high) {
        j = low;
        i = high
    }
    for (x = i; x <= j; x++) psy_clear_stimuli1(x)
}

function psy_unhide_range_db(low, high) {
    var x = 0;
    var i = low;
    var j = high;
    if (low > high) {
        j = low;
        i = high
    }
    for (x = i; x <= j; x++) psy_unhide_stimuli1(x)
}

function psy_clear_stimulus_counters_db() {
    var i = 0;
    while (i < psy_stimuli1_n) {
        psy_stimuli1[i].on = 0;
        i++
    }
    psy_stimuli1_n = psy_stimuli1_end = 0
}

function psy_random(low, high) {
    return Math.floor(Math.random() * (high - low + 1) + low)
}

function psy_random_weighted(chances, n) {
    var choosen = 0;
    var chance = 0;
    var max_chance = 0;
    var i;
    for (i = 0; i < n; i++) {
        if (chances[i] > 0) {
            chance = psy_random(chances[i] * 1e4, 1e4);
            if (chance > max_chance) {
                max_chance = chance;
                choosen = i
            }
        }
    }
    return choosen
}

function psy_random_by(low, high, by) {
    return Math.floor(Math.random() * (high + by - low) / by) * by + low
}

function psy_random_from_array(tmparray) {
    return tmparray[Math.round(Math.random() * (tmparray.length - 1))]
}

function psy_draw_all_db() {
    var i = 0;
    var activefound = 0;
    ctx.fillStyle = hexrgb(0, 0, 0);
    ctx.fillRect(0, 0, psy_screen_width, psy_screen_height);
    while (activefound < psy_stimuli1_n) {
        if (psy_stimuli1[i].on == 1) {
            activefound++;
            switch (psy_stimuli1[i].type) {
                case 0:
                    ctx.fillStyle = hexrgb(psy_stimuli1[i].r, psy_stimuli1[i].g, psy_stimuli1[i].b);
                    ctx.fillRect(psy_stimuli1[i].rect.x, psy_stimuli1[i].rect.y, psy_stimuli1[i].rect.width, psy_stimuli1[i].rect.height);
                    break;
                case 1:
                    ctx.drawImage(psy_bitmaps[psy_stimuli1[i].bitmap - 1], psy_stimuli1[i].rect.x, psy_stimuli1[i].rect.y);
                    break;
                case 2:
                    ctx.drawImage(psy_stimuli1[i].text, psy_stimuli1[i].rect.x, psy_stimuli1[i].rect.y);
                    break;
                case 3:
                    ctx.arc(psy_stimuli1[i].rect.x, psy_stimuli1[i].rect.y, psy_stimuli1[i].rect.width, 0, 2 * Math.PI, false);
                    ctx.fillStyle = hexrgb(psy_stimuli1[i].r, psy_stimuli1[i].g, psy_stimuli1[i].b);
                    ctx.fill();
                    break
            }
        }
        i++
    }
}

function psy_add_centered_rectangle_rgb_db(x, y, w, h, r, g, b) {
    var tmpx;
    var tmpy;
    psy_stimuli1[psy_stimuli1_end].x = x;
    psy_stimuli1[psy_stimuli1_end].y = y;
    psy_stimuli1[psy_stimuli1_end].type = 0;
    psy_stimuli1[psy_stimuli1_end].on = 1;
    if (x == PSY_CENTRAL) tmpx = psy_screen_center_x - w / 2;
    else tmpx = x + psy_screen_x_offset - w / 2;
    if (y == PSY_CENTRAL) tmpy = psy_screen_center_y - h / 2;
    else tmpy = y + psy_screen_y_offset - h / 2;
    psy_stimuli1[psy_stimuli1_end].rect.x = tmpx;
    psy_stimuli1[psy_stimuli1_end].rect.y = tmpy;
    psy_stimuli1[psy_stimuli1_end].rect.width = w;
    psy_stimuli1[psy_stimuli1_end].rect.height = h;
    psy_stimuli1[psy_stimuli1_end].r = r;
    psy_stimuli1[psy_stimuli1_end].g = g;
    psy_stimuli1[psy_stimuli1_end].b = b;
    psy_stimuli1_n++;
    psy_stimuli1_end++;
    return psy_stimuli1_end
}

function psy_add_centered_circle_rgb_db(x, y, radius, r, g, b) {
    var tmpx;
    var tmpy;
    psy_stimuli1[psy_stimuli1_end].x = x;
    psy_stimuli1[psy_stimuli1_end].y = y;
    psy_stimuli1[psy_stimuli1_end].type = 3;
    psy_stimuli1[psy_stimuli1_end].on = 1;
    if (x == PSY_CENTRAL) tmpx = psy_screen_center_x;
    else tmpx = x + psy_screen_x_offset;
    if (y == PSY_CENTRAL) tmpy = psy_screen_center_y;
    else tmpy = y + psy_screen_y_offset;
    psy_stimuli1[psy_stimuli1_end].rect.x = tmpx;
    psy_stimuli1[psy_stimuli1_end].rect.y = tmpy;
    psy_stimuli1[psy_stimuli1_end].rect.width = radius;
    psy_stimuli1[psy_stimuli1_end].r = r;
    psy_stimuli1[psy_stimuli1_end].g = g;
    psy_stimuli1[psy_stimuli1_end].b = b;
    psy_stimuli1_n++;
    psy_stimuli1_end++;
    return psy_stimuli1_end
}

function psy_add_centered_bitmap_db(number, x, y) {
    var tmpx;
    var tmpy;
    psy_stimuli1[psy_stimuli1_end].x = x;
    psy_stimuli1[psy_stimuli1_end].y = y;
    psy_stimuli1[psy_stimuli1_end].type = 1;
    psy_stimuli1[psy_stimuli1_end].on = 1;
    psy_stimuli1[psy_stimuli1_end].bitmap = number;
    if (x == PSY_CENTRAL) tmpx = psy_screen_center_x - psy_bitmaps[number - 1].width / 2;
    else tmpx = x + psy_screen_x_offset - psy_bitmaps[number - 1].width / 2;
    if (y == PSY_CENTRAL) tmpy = psy_screen_center_y - psy_bitmaps[number - 1].height / 2;
    else tmpy = y + psy_screen_y_offset - psy_bitmaps[number - 1].height / 2;
    psy_stimuli1[psy_stimuli1_end].rect.x = tmpx;
    psy_stimuli1[psy_stimuli1_end].rect.y = tmpy;
    psy_stimuli1[psy_stimuli1_end].rect.width = psy_bitmaps[number - 1].width;
    psy_stimuli1[psy_stimuli1_end].rect.height = psy_bitmaps[number - 1].height;
    psy_stimuli1_n++;
    psy_stimuli1_end++;
    return psy_stimuli1_end
}

function psy_set_coordinate_system(s) {
    if (s == "c") {
        psy_screen_x_offset = psy_screen_center_x;
        psy_screen_y_offset = psy_screen_center_y
    }
}

function Rectangle() {
    this.x = 0;
    this.y = 0;
    this.w = 0;
    this.h = 0
}

function psy_stimulus1() {
    this.on = 0;
    this.type = 0;
    this.r = 0;
    this.g = 0;
    this.b = 0;
    this.a = 0;
    this.bitmap = 0;
    this.x = 0;
    this.y = 0;
    this.w = 0;
    this.h = 0;
    this.rect = 0
}
var psy_stimuli1 = new Array;
for (i = 0; i < 100; i++) {
    psy_stimuli1[i] = new psy_stimulus1;
    psy_stimuli1[i].rect = new Rectangle
}
var psy_stimuli1_n = 0;
var psy_stimuli1_end = 0;

function psy_mouse_visibility(visible) {
    if (visible == 1) {
        c.style.cursor = "default"
    } else {
        c.style.cursor = "none"
    }
}
var trial_counter;
var i;
var trials_left_to_do = 0;
var tasklist_end_request = 0;
var experiment_end_request = 0;
var Timer_tasklist_begin;
var Timer_tasklist_now;
var maxtasklisttime = 0;
var TRIAL_SELECTION_RANDOM = 0;
var TRIAL_SELECTION_RANDOM_NEVER_REPEAT = 1;
var TRIAL_SELECTION_FIXED_SEQUENCE = 2;
var TRIAL_SELECTION_REPEAT_ON_ERROR = 3;
var TRIAL_SELECTION_ONCE = 4;
var error_status;
trial_counter_per_task = new Array;
task_probability = new Array;
var blockname = "";
var blockrepeat = 1;
var current_trial = new Array;
var current_task = "";
var current_block = "";

function psy_time_since_start() {}

function psy_diff_timers(starttime, endtime) {
    return endtime - starttime
}

function psy_delay(ms) {
    setTimeout(current_task + ".run();", ms)
}

function psy_delay_block(ms) {
    setTimeout(current_block + ".run();", ms)
}
var psy_chosen_n = 0;
var psy_chosen_objects = [];
var choose = {
    first: 0,
    last: 0,
    counter1: 0,
    counter2: 0,
    mouse_select_bitmap: 0,
    mouse_select_bg_bitmap: 0,
    keep: false,
    minselect: 0,
    maxselect: 9999,
    current_exit_bitmap_num: 0,
    n_selected: 0,
    exit: -1,
    exit_bitmap_1: -1,
    exit_bitmap_2: -1,
    selectedstimuli: [],
    expect_key: 0,
    timer: 0,
    getmouseclick: function (e) {
        if (choose.expect_key == 1) {
            canvas_x_offset = c.getBoundingClientRect().left;
            canvas_y_offset = c.getBoundingClientRect().top;
            tmpmouseX = e.clientX - canvas_x_offset - psy_screen_x_offset;
            tmpmouseY = e.clientY - canvas_y_offset - psy_screen_y_offset;
            tmpnum = psy_bitmap_under_mouse(0, choose.current_exit_bitmap_num, choose.current_exit_bitmap_num, tmpmouseX, tmpmouseY);
            if (tmpnum == choose.current_exit_bitmap_num && choose.n_selected >= choose.minselect && choose.n_selected <= choose.maxselect) {
                choose.stop()
            } else {
                tmpnum = psy_bitmap_under_mouse(0, choose.first, choose.last, tmpmouseX, tmpmouseY);
                tmpx = psy_stimuli1[tmpnum - 1].x;
                tmpy = psy_stimuli1[tmpnum - 1].y;
                if (choose.selectedstimuli[tmpnum] == null) {
                    if (choose.n_selected < choose.maxselect) {
                        choose.selectedstimuli[tmpnum] = psy_add_centered_bitmap_db(choose.mouse_select_bitmap, tmpx, tmpy);
                        choose.n_selected++
                    }
                } else {
                    psy_clear_stimuli1(choose.selectedstimuli[tmpnum]);
                    choose.selectedstimuli[tmpnum] = null;
                    choose.n_selected--
                }
                if (choose.n_selected >= choose.minselect && choose.n_selected <= choose.maxselect) {
                    if (choose.current_exit_bitmap_num == choose.exit_bitmap_2) {
                        psy_unhide_stimuli1(choose.exit_bitmap_1);
                        psy_clear_stimuli1(choose.exit_bitmap_2);
                        choose.current_exit_bitmap_num = choose.exit_bitmap_1
                    }
                } else {
                    if (choose.current_exit_bitmap_num == choose.exit_bitmap_1) {
                        psy_unhide_stimuli1(choose.exit_bitmap_2);
                        psy_clear_stimuli1(choose.exit_bitmap_1);
                        choose.current_exit_bitmap_num = choose.exit_bitmap_2
                    }
                }
                psy_draw_all_db()
            }
        }
    },
    timeout: function () {
        window.removeEventListener("mousedown", choose.getmouseclick, false);
        psy_clear_stimuli1(choose.exit_bitmap_1);
        psy_clear_stimuli1(choose.exit_bitmap_2);
        if (!choose.keep) {
            for (i = choose.first; i < choose.last; i++) {
                if (choose.selectedstimuli[i] != null) {
                    psy_clear_stimuli1(choose.selectedstimuli[i])
                }
            }
            psy_stimuli1_n = choose.counter1;
            psy_stimuli1_end = choose.counter2
        }
        psy_draw_all_db();
        choose.expect_key = 0;
        choose.maxselect = 9999;
        eval(current_task + ".run()")
    },
    stop: function () {
        keystatus.time = (new Date).getTime() - choose.starttime;
        psy_chosen_n = 0;
        psy_chosen_objects = Array(100).fill(0);
        for (i = choose.first; i <= choose.last; i++) {
            if (choose.selectedstimuli[i] != null) {
                psy_chosen_objects[psy_chosen_n] = i;
                psy_chosen_n++
            }
        }
        clearTimeout(choose.timer);
        choose.timeout()
    }
};

function psy_choose(maxtime, stimulus_first, stimulus_last, exit1, exit2, exit_x, exit_y) {
    choose.counter1 = psy_stimuli1_n;
    choose.counter2 = psy_stimuli1_end;
    choose.exit_bitmap_1 = psy_add_centered_bitmap_db(exit1, exit_x, exit_y);
    choose.exit_bitmap_2 = psy_add_centered_bitmap_db(exit2, exit_x, exit_y);
    psy_clear_stimuli1(choose.exit_bitmap_1);
    psy_clear_stimuli1(choose.exit_bitmap_2);
    choose.expect_key = 1;
    choose.n_selected = 0;
    choose.first = stimulus_first;
    choose.last = stimulus_last;
    choose.selectedstimuli = [];
    if (choose.n_selected >= choose.minselect && choose.n_selected <= choose.maxselect) {
        psy_unhide_stimuli1(choose.exit_bitmap_1);
        choose.current_exit_bitmap_num = choose.exit_bitmap_1
    } else {
        psy_unhide_stimuli1(choose.exit_bitmap_2);
        choose.current_exit_bitmap_num = choose.exit_bitmap_2
    }
    psy_draw_all_db();
    window.addEventListener("mousedown", choose.getmouseclick, false);
    choose.timer = setTimeout("choose.timeout()", maxtime);
    choose.starttime = (new Date).getTime()
}

function psy_scale_point_x(x, realx, realw, xlim1, xlim2) {
    xlimrange = xlim2 - xlim1;
    rangefactor = realw / xlimrange;
    return realx + (x - xlim1) * rangefactor
}

function psy_scale_point_y(y, realy, realh, ylim1, ylim2) {
    ylimrange = ylim2 - ylim1;
    rangefactor = realh / ylimrange;
    return realy + realh - (y - ylim1) * rangefactor
}

function psy_palette(colornumber) {
    switch (colornumber) {
        case 1:
            color = "white";
            break;
        case 2:
            color = "red";
            break;
        case 3:
            color = "green";
            break;
        case 4:
            color = "yellow";
            break;
        case 5:
            color = "blue";
            break
    }
    return color
}

function psy_plot_xaxis(x, y, w, xlim1, xlim2) {
    var i;
    for (i = xlim1; i < xlim2; i++) {
        if (i % 100 == 0) {
            ctx.fillStyle = "white";
            ctx.font = "12px Arial";
            ctx.fillText(i, psy_scale_point_x(i, x, w, xlim1, xlim2) - 10, y + 20);
            ctx.beginPath();
            ctx.moveTo(psy_scale_point_x(i, x, w, xlim1, xlim2), y);
            ctx.lineTo(psy_scale_point_x(i, x, w, xlim1, xlim2), y + 8);
            ctx.stroke()
        } else {
            if (i % 10 == 0) {
                ctx.beginPath();
                ctx.moveTo(psy_scale_point_x(i, x, w, xlim1, xlim2), y);
                ctx.lineTo(psy_scale_point_x(i, x, w, xlim1, xlim2), y + 4);
                ctx.stroke()
            }
        }
    }
}

function psy_plot_yaxis(x, y, w, ylim1, ylim2) {
    var i;
    for (i = ylim1; i < ylim2; i++) {
        if (i % 50 == 0) {
            ctx.fillStyle = "white";
            ctx.font = "12px Arial";
            ctx.fillText(i, x - 30, psy_scale_point_y(i, y, w, ylim1, ylim2) + 3);
            ctx.beginPath();
            ctx.moveTo(x - 8, psy_scale_point_y(i, y, w, ylim1, ylim2));
            ctx.lineTo(x, psy_scale_point_y(i, y, w, ylim1, ylim2));
            ctx.stroke()
        } else {
            if (i % 10 == 0) {
                ctx.beginPath();
                ctx.moveTo(x - 4, psy_scale_point_y(i, y, w, ylim1, ylim2));
                ctx.lineTo(x, psy_scale_point_y(i, y, w, ylim1, ylim2));
                ctx.stroke()
            }
        }
    }
}

function psy_plot_circle(x, y, radius, colorname) {
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, 2 * Math.PI);
    ctx.fillStyle = colorname;
    ctx.fill()
}

function numsort(a, b) {
    return a - b
}

function minimum(a) {
    tmp = a.slice();
    return tmp.sort(numsort)[0]
}

function maximum(a) {
    tmp = a.slice();
    return tmp.sort(numsort)[tmp.length - 1]
}

function psy_xyplot(x, y, w, h, box, col, xdata, ydata, xlabel, ylabel) {
    xlim1 = minimum(xdata) - 10;
    xlim2 = maximum(xdata) + 10;
    ylim1 = minimum(ydata) - 10;
    ylim2 = maximum(ydata) + 10;
    for (i = 0; i < xdata.length; i++) {
        psy_plot_circle(psy_scale_point_x(xdata[i], x, w, xlim1, xlim2), psy_scale_point_y(ydata[i], y, h, ylim1, ylim2), 4, psy_palette(col))
    }
    ctx.beginPath();
    ctx.strokeStyle = psy_palette(col);
    ctx.rect(x, y, w, h);
    ctx.stroke();
    psy_plot_xaxis(x, y + h, w, xlim1, xlim2);
    psy_plot_yaxis(x, y, h, ylim1, ylim2);
    ctx.fillStyle = "white";
    ctx.font = "12px Arial";
    ctx.fillText(xlabel, x + w / 2, y + h + 30);
    ctx.save();
    ctx.translate(x - 50, y + h / 2);
    ctx.rotate(-Math.PI / 2);
    ctx.textAlign = "center";
    ctx.fillText(ylabel, 0, 0);
    ctx.restore()
}

function psy_lineplot(x, y, w, h, box, ydata, colors, xlabel, ylabel) {
    xlim1 = 1 - 5;
    xlim2 = ydata.length + 5;
    ylim1 = minimum(ydata) - 10;
    ylim2 = maximum(ydata) + 10;
    previousx = 0;
    previousy = 0;
    for (i = 0; i < ydata.length; i++) {
        tmpx = psy_scale_point_x(i, x, w, xlim1, xlim2);
        tmpy = psy_scale_point_y(ydata[i], y, h, ylim1, ylim2);
        psy_plot_circle(tmpx, tmpy, 4, psy_palette(colors[i]));
        if (i > 0) {
            ctx.strokeStyle = "white";
            ctx.beginPath();
            ctx.moveTo(previousx, previousy);
            ctx.lineTo(tmpx, tmpy);
            ctx.stroke()
        }
        previousx = tmpx;
        previousy = tmpy
    }
    ctx.beginPath();
    ctx.strokeStyle = "white";
    ctx.rect(x, y, w, h);
    ctx.stroke();
    psy_plot_xaxis(x, y + h, w, xlim1, xlim2);
    psy_plot_yaxis(x, y, h, ylim1, ylim2);
    ctx.fillStyle = "white";
    ctx.font = "12px Arial";
    ctx.fillText(xlabel, x + w / 2, y + h + 30);
    ctx.save();
    ctx.translate(x - 50, y + h / 2);
    ctx.rotate(-Math.PI / 2);
    ctx.textAlign = "center";
    ctx.fillText(ylabel, 0, 0);
    ctx.restore()
}

function psy_fullscreen(o) {
    if (o.requestFullScreen) o.requestFullScreen();
    else if (o.webkitRequestFullScreen) o.webkitRequestFullScreen(c.ALLOW_KEYBOARD_INPUT);
    else if (o.mozRequestFullScreen) o.mozRequestFullScreen();
    else if (o.msRequestFullscreen) o.msRequestFullscreen()
}

function psy_exit_fullscreen() {
    if (document.exitFullScreen) document.exitFullScreen();
    else if (document.webkitCancelFullScreen) document.webkitCancelFullScreen();
    else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
    else if (document.msExitFullscreen) document.msExitFullscreen()
}

function formatoutputdata(text) {
    tmp = text.split(/\r?\n/);
    out = "";
    for (i = 0; i < tmp.length - 1; i++) {
        tmp2 = tmp[i].split(/\s+/);
        out = out + "<tr>";
        for (j = 0; j < tmp2.length; j++) {
            out = out + "<td>" + tmp2[j] + "</td>"
        }
        out = out + "</tr>"
    }
    return out
}

function showdata_html() {
    showdata.innerHTML = "<table id='outputTable' class='table table-striped'><thead><tr><td><b>Trial Number</b></td><td><b>Trial Type</b></td><td><b>Response</b></td><td><b>Response Time</b></td><td><b>Letter Shown</b></td><td><b>Letter Two-Back</b></td></tr></thead><tbody>" + formatoutputdata(outputdata) + "</tbody></table>";
    
    var hiddenDiv = document.getElementById("resultsDiv");
    hiddenDiv.classList.remove("hidden");
}
var letterA = 1;
var letterB = 2;
var letterC = 3;
var letterD = 4;
var letterE = 5;
var letterH = 6;
var letterI = 7;
var letterK = 8;
var letterL = 9;
var letterM = 10;
var letterO = 11;
var letterP = 12;
var letterR = 13;
var letterS = 14;
var letterT = 15;
var arial = 0;
var maxrt = 2500;
var trialcount = 0;
var nback2 = 0;
var nback1 = 0;
var task_nback = {
    step: 1,
    task_trial_selection: 0,
    current_trial: -1,
    taskname: "task_nback",
    tasknumber: 1,
    start: function (trial_selection) {
        task_nback.trial_selection = trial_selection;
        task_nback.step = 1;
        psy_clear_stimulus_counters_db();
        task_nback.run()
    },
    currentletter: 0,
    memory: 0,
    requiredresponse: 0,
    extrawait: 0,
    score: 0,
    feedbackcol1: 0,
    feedbackcol2: 0,
    run: function () {
        current_task = task_nback.taskname;
        switch (task_nback.step) {
            case 1:
                task_nback.step++;
                task_nback.currentletter = task_nback.memory = task_nback.requiredresponse = task_nback.extrawait = task_nback.score = task_nback.feedbackcol1 = task_nback.feedbackcol2 = 0;
                error_status = 0;
                psy_add_centered_rectangle_rgb_db(PSY_CENTRAL, PSY_CENTRAL, 300, 300, 255, 255, 255);
                psy_draw_all_db();
                possiblekeys = [89, 78];
                trialcount = trialcount + 1;
                task_nback.currentletter = psy_random(1, 15);
                task_nback.memory = psy_random(1, 4);
                if (!(task_nback.memory == 1 && trialcount > 2)) {
                    task_nback.step = 3
                };
                eval("task_nback.run()");
                break;
            case 2:
                task_nback.step++;
                task_nback.currentletter = nback2;
                task_nback.requiredresponse = 1;
                task_nback.run();
                break;
            case 3:
                task_nback.step++;
                if (!(task_nback.memory != 1 || trialcount <= 2)) {
                    task_nback.step = 8
                };
                eval("task_nback.run()");
                break;
            case 4:
                task_nback.step++;
                task_nback.currentletter = psy_random(1, 15);
                eval("task_nback.run()");
                break;
            case 5:
                task_nback.step++;
                if (!(task_nback.currentletter == nback2)) {
                    task_nback.step = 7
                };
                eval("task_nback.run()");
                break;
            case 6:
                task_nback.step++;
                task_nback.currentletter = psy_random(1, 15);
                task_nback.step = 5;
                task_nback.run();
                break;
            case 7:
                task_nback.step++;
                task_nback.requiredresponse = 2;
                task_nback.run();
                break;
            case 8:
                task_nback.step++;
                psy_add_centered_bitmap_db(task_nback.currentletter, PSY_CENTRAL, PSY_CENTRAL);
                psy_add_centered_rectangle_rgb_db(0, -100, 150, 20, 125, 125, 125);
                psy_add_centered_rectangle_rgb_db(0, 100, 150, 20, 125, 125, 125);
                psy_draw_all_db();
                psy_keyboard(possiblekeys, 2, task_nback.requiredresponse - 1, maxrt);
                break;
            case 9:
                task_nback.step++;
                task_nback.extrawait = Math.round(maxrt - keystatus.time);
                task_nback.score = 0;
                task_nback.feedbackcol1 = 255;
                task_nback.feedbackcol2 = 0;
                if (!(keystatus.status == 1)) {
                    task_nback.step = 11
                };
                eval("task_nback.run()");
                break;
            case 10:
                task_nback.step++;
                task_nback.feedbackcol1 = 0;
                task_nback.feedbackcol2 = 255;
                task_nback.run();
                break;
            case 11:
                task_nback.step++;
                psy_add_centered_rectangle_rgb_db(0, -100, 150, 20, task_nback.feedbackcol1, task_nback.feedbackcol2, 40);
                psy_draw_all_db();
                psy_add_centered_rectangle_rgb_db(0, 100, 150, 20, task_nback.feedbackcol1, task_nback.feedbackcol2, 40);
                psy_draw_all_db();
                psy_delay(task_nback.extrawait);
                break;
            case 12:
                task_nback.step++;
                psy_clear_stimuli1(2);
                psy_clear_stimuli1(5);
                psy_clear_stimuli1(6);
                psy_draw_all_db();
                psy_delay(500);
                break;
            case 13:
                task_nback.step++;
                psy_clear_stimuli1(3);
                psy_clear_stimuli1(4);
                psy_clear_stimuli1(5);
                psy_clear_stimuli1(6);
                psy_draw_all_db();
                nback2 = nback1;
                nback1 = task_nback.currentletter;
                var trialType = task_nback.memory;
                switch(trialType){case 1: trialType = "Two-Back"; break; default: trialType = "Non-Two-Back"; break;};
                var nback2Formatted = "";
                switch(nback2){case 0: nback2Formatted = "Start";break;case 1: nback2Formatted = "A"; break; case 2: nback2Formatted = "B"; break; case 3: nback2Formatted = "C"; break; case 4: nback2Formatted = "D"; break;case 5: nback2Formatted = "E"; break;case 6: nback2Formatted = "H"; break;case 7: nback2Formatted = "I"; break;case 8: nback2Formatted = "K"; break;case 9: nback2Formatted = "L"; break;case 10: nback2Formatted = "M"; break;case 11: nback2Formatted = "O"; break;case 12: nback2Formatted = "P"; break;case 13: nback2Formatted = "R"; break;case 14: nback2Formatted = "S"; break;case 15: nback2Formatted = "T"; break;};
                var currentLetterFormatted = "";
                switch(task_nback.currentletter){case 0: currentLetterFormatted = "Start"; break; case 1: currentLetterFormatted = "A"; break; case 2: currentLetterFormatted = "B"; break; case 3: currentLetterFormatted = "C"; break; case 4: currentLetterFormatted = "D"; break;case 5: currentLetterFormatted = "E"; break;case 6: currentLetterFormatted = "H"; break;case 7: currentLetterFormatted = "I"; break;case 8: currentLetterFormatted = "K"; break;case 9: currentLetterFormatted = "L"; break;case 10: currentLetterFormatted = "M"; break;case 11: currentLetterFormatted = "O"; break;case 12: currentLetterFormatted = "P"; break;case 13: currentLetterFormatted = "R"; break;case 14: currentLetterFormatted = "S"; break;case 15: currentLetterFormatted = "T"; break;};
                var keyStatusFormatted = keystatus.status;
                switch(keyStatusFormatted){case 1: keyStatusFormatted = "Correct";break;case 2: keyStatusFormatted = "Incorrect"; break; case 3: keyStatusFormatted = "Response-Timed-Out";break;};
                addoutput(trialcount + " " + trialType + " " + keyStatusFormatted + " " + keystatus.time + " " + currentLetterFormatted + " " + nback2Formatted);
                eval(current_block + ".run()");
                break
        }
    }
};
var block_training = {
    blockname: "block_training",
    step: 1,
    trial_counter: 0,
    trial_counter_per_task: [0],
    max_trials_in_block: 999999,
    criteria_fullfilled: 1,
    choosetask: 0,
    start: function () {
        block_training.step = 1;
        current_block = "block_training";
        block_training.trial_counter_per_task[0] = 30;
        psy_clear_stimulus_counters_db();
        block_training.run()
    },
    run: function () {
        current_block = block_training.blockname;
        switch (block_training.step) {
            case 1:
                block_training.step++;
                psy_clear_screen_db();
                block_training.max_trials_in_block = 999999;
                block_training.criteria_fullfilled = 1;
                if (block_training.criteria_fullfilled > 0 && block_training.trial_counter <= block_training.max_trials_in_block) {
                    task_nback.start(TRIAL_SELECTION_RANDOM)
                } else {
                    eval("block_training.run()")
                }
                break;
            case 2:
                block_training.step++;
                block_training.trial_counter_per_task[0]--;
                if (block_training.trial_counter_per_task[0] == 0 || block_training.trial_counter >= block_training.max_trials_in_block || tasklist_end_request == 1) {
                    block_training.criteria_fullfilled = 0;
                    tasklist_end_request = 0
                }
                if (block_training.criteria_fullfilled == 1) {
                    block_training.step = block_training.step - 2;
                    eval("block_training.run()")
                } else {
                    eval("block_training.run()")
                }
                break;
            case 3:
                block_training.step++;
                psy_clear_screen_db();
                eval("blocks" + psy_blockorder + ".run()");
                break
        }
    }
};

function main() {
    c.focus();
    psy_screen_height = 300;
    psy_screen_width = 300;
    psy_screen_center_x = psy_screen_width / 2;
    psy_screen_center_y = psy_screen_height / 2;
    psy_set_coordinate_system("c");
    psy_exp_start_time = psy_exp_current_time = (new Date).getTime();
    psy_mouse_visibility(0);
    psy_load_font("Arial", 18);
    psy_load_bitmap("data:image/png;base64,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");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAAExklEQVR42u2dy3HbSBRF73NpL2ZAOAIzAyMDMwPDGWgywGTAEMgMqAhMZQBFYDIDKoI3C0BlWeVyjSz0B93nbCQtVATIw/u6G/0xdxfA3HzgLQDEAsQCxAJALEAsQCwAxALEAsQCQCxALEAsAMQCxALEAkAsQCxALADEAsQCxAJALEAsQCyA93AT+wXNjKXXP3mSNEi6Tj8HSYO7n5d+YxZ7iT1i/W/hTpKOko7ufkUsxArBvaS9ux8RC7FCcJHUu/sesRArlGCdu5/oFcKcrCV9N7Odma1ILBIrBI+Strn1JBGrnF5k6+4DpRDm5FbSycw2iAVFy0UpLLPHuEk9qEpildljTD6Qilhl8tnM7iiFEKqnuEk1DEFild2Y70ksCMXHFKlFYpVPkrYWiVVBW8vdoz9PJLEqaGuZ2RaxIAQtYkERYtHGqgR3t5ivd1Pp+/zg7u1ffjFe/99GUjOlwqdcb9jM2pgzTm/4Lr/5m//6wzm9+PBWkjqNA5O3Nb9PtLHmle7q7rspwQ41t7MQK5xgXYZyIVYhgnUa56QjFszOHWJBqMb+BbEgBKfargGx4nAmsaDkkoxYMCvR23iIRRsPsRZM6kWkR8Qqkzbhaz+l2LANsQJjZp3SPpBOsngVscJKtVLCJVgTPWKVx07jkvdUHFItWGU+Vrik2kv6krJtlTItEWteoRqNE/3ulH6iX59ylz/Eers87W+GEhrlNTX5fppwmO59YjFFcTxq3DbyilgwZ7uqyeEkC3qFZSXVJpfjURCrDO6n8nfO5YIQa/ml7x933+Z2kBNiLZfDVPp2OV4cww3LFKrP/UxDxFoGF40j+fulHJJJKVwGa40DsNucTp/4E4xjLXdo4TnBroiFWNW0uSiFy+erpB9mtp8egpNYMDtPknbu3iMWhOBB49G+Z8SCEOmV7HBM2ljlkvT8QsRCLkohvKssRj0JjMSqJ7miri9ErHr4ZGY9pTBwd/xv93l/cR8bSa8PP2o1LqzYKM8936OVRMQKd58rSVuNa/vWGcl1mDbdpRQukWlL7r27N5K+TWmRA19jPPpBrDiS7acymYtcJFZBcg0ZyYVYBcrVZ3Ap69CDpogVX66d8tj3vUWs8jgiFiAWYi2GcwbXcItY5bWzchDrd1syIRbkDWIVlhRvZIVYZdFkch0bxCqLtvQbRKz4ZXClcS0gYsGs5LTt0Amxykirroa0Qqz4PcFdLfeLWHGk6iV9V/pDBX4h5KmrbLwWTqZG47ynTnlNTX4m6AwLxHpf7+7lONDz3800nLDO/BYGxJqfzyycDXucL20sxAqT6Cyxr5LLtHqIxIJZ2QcPEBKrSj6GnhNGYtXHgSX2sMi0IrFIKxIL3k3UQzJJrHroYp5igVj1lMCoaxkpheWT5PBxEgupEAve3FjvUp0OhljlJlWT6lQKxCqTh1TlD7HK5V93b3M4HJMZpOWk1F3K0kdilcVF0rcppYacLozEWmZv7yjpGHvQE7HKLHWDpFPOMiFWvkk0aNzt7/z8e24lDrHylEbTz+sLga5LledPRH9WCHVArxAQCxALEAsAsQCxALEAEAsQCxALALEAsQCxABALEAsQCwCxALEAsQAQCxALEAsAsQCxALEAEAvy4z9kiwokb2k0hgAAAABJRU5ErkJggg==");
    psy_load_bitmap("data:image/png;base64,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");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAAEPUlEQVR42u3d3W0aQRSG4e9Evrc7MB2YDrypwLgC04HpwKSCkA5IBcEdLBUEKgjuACo4uWCjWFFsyzIze2b2fSUrVnLBQB7NDLA/5u4iOnWfeAkIWAQsAhYRsAhYBCwiYBGwCFhEwCJgEbCIgEXAImARAYuARcAiAhYBi4BFBCwCFgGL6COd5X5AM2slXVf8mh4kbbrfd89/3L0dCizLfYr9AGC91VMHr5XUuvsGWMBKNcOtJK3cfcUei07VuaQ7ST/MbG9mCzMbAYtOjexe0i8zW5YMDFhxuysZGLDKATYHFqXowcw2ZjYGFp26K0k/zWwGLErR127vdQEsSrH3aqPiAlb5S2NIXMACF7CoHFzAqgvXEliUopsoH6QCq74ezKwBFqVo1fd+C1h1dt73fgtYde+3GmBRipbAohRd9vWFNbDqb97HRh5Yw9jIz4BFKZrmfsCzgb7Qa3d/8R1Tt3T8e6Tmn78bdT8lncJ2aWZTd8+2mR/qeYWvwnrHc2kkTbqfy+C4tu6e7bBmlsIP5O6tu8/cfSTpVtI68HCvch4vD6zTIVt1s+BnHU+jH/ReC1gJZrFuL/Y94PAmwCob197dpwFxXeZaDoGVFlhEXBNg1YNrG2hIDbDqaRpoLNfAqmfW2kRaEnMcTgOsfM2HtBwCK9+stZP0CCxKUZRLQY6BBawUnac+RgtYeZfDveJ8nzgGVl21wKIURbmuO0shsMp7Zwis/Pus3RCeJ7D6KcIG/hpYxIxF5bwzTPlZFrCG3RhYxFJIb7YBFqVoDywiYBGwCFhEwCJgEbCIgEXAGmoNsIiARe+pu5YXsCpqxIxFwAIWsN7RFlj1FeHS3XtgVVSEu5927YDFMggsejNmLAIWsMrYX42DbNyTfjgKrPzNgowj+S1ZgJVvtrqQdBdkOC2w6mkeaCwbYNWzt7oPNCRmrEqWwGWgIR26GxoAq/AWkq4CjSfLlZuBlXa2WgbasGeFdcZ/f9Ll7ybY0A7uzoxVKKqpjp9q3wQcXrYbGDBjnWZ2avT3bvbngYc7B1b/YJoX/ql59udFsI35a61zXrF5qLCuzcwH9pznOR+MPdYwWqf+0hlYw2ye+wGBVX+PuWcrYNXfQT0dqgOsypfAvu7dA6y6N+yLvh4cWPUugdM+BwCsOpv2ffs6YNXXt1xfNANrOH139xAnbACrnraKcxYQsCpC1bj7Hlh0qtbRUAGrjj1VOFTAKrsv7j6NOjgO9Cuvg6RJH18sM2PV26OkUXRUwCqnJ0m37j6JuJ9iKSxz2VtIWpQCCljxZ6hliaCAFXN2WklaRfiuD1hlt9bxyi9tCRtyYMVsq+N1qTaSNrVBAlZ6PHsdT7HfdYj2tSP6X+bucKCTx+dYBCwCFgGLCFgELAIWEbAIWAQsImARsAhYRMAiYBGwiIBFwCJgEQGLgEXAIgIWAYuARQQsitdvx7E53K8580sAAAAASUVORK5CYII=");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAABdElEQVR42u3dwQ2DMBBFwd2IwkhnSWWks8/B55wgQsEzDSDM0/qCoZMUnO1hCRAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFggLYSEsOGK58uLdvVbV5jH8VpI2sbAVgrAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshMW/WSxBVVU9k3wsg4mFsBAWCAthISwQFsJCWCAshIWwQFgIC2HBAd7HGrbuvs3NXPH5bRMLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshIWwQFgIi6k5pTP4arKJhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEsJuEwxXCrX5588U7yMrGwFYKwEBbCAmEhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlgIC4SFsBAWnK2TWAVMLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshMUEdoWHG7+VDsX3AAAAAElFTkSuQmCC");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAABZklEQVR42u3cQQrCQBBE0S7x3mZOXl7AnYaM5D3IOqH5zKzSaTvwaw8jQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbDgG8+zX5Bkh1+tV9tjl6EnOWbmdfV3tI0TC1chCAthISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFgiLbaQ9d6nxJluT+cDWZFyFICyEhbBAWAgLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshAXCQlgXW22zyzMzS1ggLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWw+E9pawo4sRAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBY38AZRboDzlF9PJAAAAABJRU5ErkJggg==");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAABRklEQVR42u3UgQmAMAxFwUTcq45uJ/sOUUGwdxMk4ZFOUvC2wwkQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLFhx7rJod99VNT4eYya5fCwQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCAthISwQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFggLYfE3ncQV8LEQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshIWwQFgIC2GBsBAWG3gAOycMO3unM68AAAAASUVORK5CYII=");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAAE2UlEQVR42u2d23EaQRBF7zgBlAFyBMIRgCOwMhCKQHIEwhmQgSEDOQJDBiIDlIGJoP3hrbIetsRjZ7Z755wqvpmlTt1uenZnk5kJoG0+8BMAYgFiAWIBIBYgFiAWAGIBYgFiASAWIBYgFgBiAWIBYgEgFiAWIBYAYgFiAWIBIBYgFiAWwEmYWdaPJHPwmeW+zj1/i4WT32Pfz4Oks2OulcQqREppJukq0JI3kiZm9otS6FeqqaS7QEveSZoeKxVilZFqJOl7MKkmZvZA8+5bqlVtUiFWXqnOmmZ9UJtUiJWXlaSLGqVCrHxptahZKsRirJBFKsRirJBFKsSqe6xwnUsqxKp3rHBtZoucX4BY9Y0VskuFWPWNFYpIhVh1jRWKSYVY9YwVikqFWHWMFYpLhVj9Hyt860IqxOr3WGFpZrOuvhyx+jlWWJrZtMsFIFb/xgqdS4VY/RsruJAKsfo1VnAjFWL1Z6zgSirEeluqSZCxgjupEOvtscJ9gKVuPEqFWP8fK9wHGCtsJE28Lg6xXku1kjSMINUpD5QiVlnmAcYK7qVCrOdpNQ8wVgghFWI9HyvcIBVi1TZWCCVV9WIFGSs8RpOqarGCjBV2ki6jSVWtWEHGCtmeUkasescKoaWqUqwAY4XwUlUnVoCxQi+kqkqsAGOF3khVk1jexwq9kkqSUnP+eM6kMMF7fDWzea8qBGK54FHSKOK8iubdN0NJMxKLxMrFJ5p3yEFv+izE8sU4pXRLKaQU5mAn6Tx6I09i+WPQh5JIYvnls5mtEAux2mZjZiNKIbTNRXNuBIlFYmVp5EdmtiWxgEYesULwJaV0SSmkFOYg3CY1iRWDoaRQE3kSKxZhNqlJrFiEaeQRKxbj5oEQSiGlsHVCbFKTWPEYKMDdpiRWXFxvUiNWXFxvUlMK92ftbD0Xnu82JbH241p/HnjdytexR243qUms91ma2aL5F+ZtjuR2k5rEel+q6Yvr2crfuVruGnkS6wCpGjz+1V80h8khVlCp1LwK99HZet1tUlMKD5DqyTVN5fNIpI9eGnnEOlAq573W2swmlEJfbA4sJx57rbGXu01JrL9SHXyWutPUcrFJTWKd9tYHj6nlYpO69sQ6+VUiTlNL6vhu05oTq63300ydXt+CUlie1t5P00y81w6vsdNN6hpLYesnFDdHff90KFdnjXxtiZXl2GvHqTXoqiTWlFhZz1J3nFpSB5vUtYhV5ID+lNJK0thjT2lm55TC9pkX+us9c3r9w9JHIjEgraPXkqTblNI5YsXFa2oVbeQRK09q/XC6vGKb1IiVqex47jdL3G2KWHlSaytp6bWRL1GuEau+XkuSblJKI8QitbKURMQitXI18reIRWplET9XI49YdadWtiepEYvUumo20BEraGrtamrkEatcank+mLb19/YgVtlU8JxarW5SI1a51PJ4DFK2Rh6xSK2ntPbeHsQitV7J38ZsC7FIrZe0ciQSYpFa/+Lu1E1qxCK13lojYgVMrZnzZZ703h7E6k6uufwdOdlaI49Y3eI9tY4+Egmxuk2tRYDUujlmkxqxSK0sjXz2R+yhTkgsQCxALEAsAMQCxALEAkAsQCxALADEAsQCxAJALEAsQCwAxALEAsQCQCxALEAsAMQCxALEAkAs8Mdv36hyDmb+XOkAAAAASUVORK5CYII=");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAABVElEQVR42u3U0QmAMAxF0UY6mE5eN3su4F9Fip4zQRIuqSQNnrY5AcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFM/pKw1TV3lobC4xyJDnl4WMhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbBYU3eCW6OqPrNMkteX8bEQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLJhSSVwBHwthISwQFsJCWCAshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2HxAxcdfg/9pE5EdAAAAABJRU5ErkJggg==");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAADyUlEQVR42u3cwVHbQBQG4FUmd+jAdEA6sDqIS6KUlOB0sHQQOoAOoILNIT7kAJmM0ZO0+75/xkdAWn08/WNbO7XWisjS+WIJBCwBS8ASAUvAErBEwBKwBCwRsAQsAUsELAFLwBIBS8ASsETAErAELBGwBCwBS+RTaa1d9SqlPJRSWkevH9ee61KvDtfs4dpzzTSxZsfgVhiRwzRNd1v98WmabkspR7BMLdMKLLDAAgusQXvWt4361T1YppZpBRZYYIEF1sC5WbNnZexXWWGtPUHmjAsMVnxOYOXJdxMLrKjuM6/wN+5KKQew3A5NK7DAAmufOYIFVnc9K3O/Sg8reKLMmRc2O6wTWGBF5P7ykQtYYO0fwOWzyANYYJlWYIEFVt6eBRZXy0K49KubwGN9AmvZPHZyO5yDUb2CtWxq4O8+dQKr9nKxwPqTJR+/B6snWK216EX9NIjoftVaO4OVs2fNnZ57eljnncOK/OyxgpW3Zx3B6hBWa+1XKeVtj1Mr+jv0K3TM1BMr+j933uhnh+pXYC3bkbzNANaH+czj9/pVz7D22LP0qzEm1h57ViSsnz1eILD2D6uClbBnrbDNNlhJe1bktHq7nCtYKyby453TTmDVXi9Oz7AiF/0IFlgh+Z+3EFbYBhKsDXrWcynlZeOepV8NOLH28LaD2yBYIT0LLLCW7Vkr9KszWOP2rNNG0+rlcm5gJexZvoYM1tX51+P3+tXgsKK7yPxOv7orsdsUgbWDnvVaYvczmPWrnBNri57lNghWSM8CC6xlp5Z+lQjWCj3rpF/lnFhr9iy3QbAWy9+P30fCOoOVsGetsM22iZWwZ83B0+rpcg5D5GsZK7XEfeNgLqXcBh/7MBlt1+TIjnJQ3JPCWuFR9Buwck6sUjrc8me0fjUqrOqYwXKRwNKzwMo9sXrrWY+j9auRYVXHChZYYHXVs946OlawTIK0XRCsjmBVsMACC6xVtpPUr5JOrL1PhMeRFx6s7XIGCyz9CqwuelbX20CaWPudDHX0RQfLMYE1UEkGa4Ce9Vxit5PUr5JOrL1NiJphwcECCyywwNKz3s9Lhn6VaWLtZVLULIsNFlhggQWWnvV+v3oGa8xs+S58zbTQ2WBVsMACC6xuelb0dpL6VdKJtdXkqNkWGSywwOr4Ip/B0rOWztOI2xSBtf3UqhkXGCywwAILrB561hqPuKfsV5kn1lqTpGZd3Km1VkRMLAFLwBIBS8ASsETAErAELBGwBCwBSwQsAUvAEgFLwBKwRMASsAQsEbAELAFLBCwBS8bPb/fBRA1cr/UMAAAAAElFTkSuQmCC");
    psy_load_bitmap("data:image/png;base64,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");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAADbUlEQVR42u3d723bRgDG4feKfI83sDaINogzQd0Jog3qTlB3gnqDqBNUmSDKBvIEVTawJ7h+EIsWRdI2KCkeT8/zRYBhQCT1w/HEfyq11sDYvrEJEBbCQlggLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWCAthISz4P17M+eallJskHy5wu38cXg9JnpLskxxqrU+9rGCZ8xb7Cw7rSz4Nke2T7JYcmrDa9pjkYYmRmWO17VWSd0mOpZRtKWUlLMb0MsnbJL+VUh5KKVfCYmzfDyPYRlhMMYK9K6XsWh29hLVs3ybZl1LWwmKKCX5zcQmrn11jU3EJq6+4mplzCasv1zkdtRcW48+5Sin3wmIKP8493xJWvx6ExRRel1JuhcUU7oXFVBP5G2ExhY2wmMLbOQ6aCusy3AqLKZx9nvXCNk+SvKm17v/pH4bLglef+cCuhtdXwhLWV6u1HpMc//bn/V/Cuxp2OXcNRnZdSlkN62BXuLDwnmqt21rrOsl3SZ4bW8SznuIR1jSR7YYP8lFYTLHr3DQ0cgmro7gOw5yrBVfC6iuubf58VsOcVsLqz0MDy3AtrD4n88+XtM7COp+DsJjCXlggLISFsBjdjbCYwlpYjGp4SNrLmRfjo7D6c3dpKyys6UerVi782wurn6huk/zcyOIchdXPvOrXhhbpIKxlB7UqpWxzej57M4Zrw87GzRTj7vZuc3oee2ven/sNhfUfR6F8+davdZLXja/CXljz+FBK6Xn9dg43MLbHc95PKKzLMctl0cLq2/Mcu0FhXcBoNdfvHAqr79FqtruDhNWv+zl/lVVY/X4T9DhuRt8FbuZeCGH15+7c5wWF1b9fhmdFRFiMGdWmlYURlqiExTKiEtby/dBiVInLZpbqU5LbFr79GbH68VOSdctRGbEWNpfK6TTNcQkLK6y2/XEiebuUoITVdky7JLvhEZOLJKw2QjrkdMPD/t9+00dYfC6eDK9PQ0jHpe3ihPV13vQyUrTC4QaEhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshIWwQFi0odRabQWMWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCIsL8Dt0N9uSbvB24QAAAABJRU5ErkJggg==");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAAE90lEQVR42u2d0XHbOBRF78vkX+7A2gqsVEClgnUH1lYQbQXmVhClgigdyBUsXUGYDuQKolTw9kPIjzeZjCMCfCDPmfGMpB+D0pmLRwAEzN0FMDSv+AoAsQCxALEAEAsQCxALALEAsQCxABALEAsQCwCxALEAsQAQCxALEAsAsQCxALEAEAsQCxAL4BJel/6HZtZJamb8nT9JOqbXJ0l9et1LOrl7N4WLtNKP2CPWi+TrJHU1yoZY9fAo6SBp7+4naiwYikbSe0lfzWxvZmvEgqG5k/SvmXVmtkIsyJFin82sRSzIwb2Z9Wa2RCwYmhtJfZSuEbGmxUJSiLoLsZALseDFci0RC3LIdUAsyFLQm9kOsSAH78YYpUesedAiFuSgMbMNYkEOtogFuQr5FWJB1amFWPPiFrEgB4tSQw+INT+KiPV6pl/uo7v/1hecCuCrH/xYV5JWir+eH7Ei4u79Dz7unsl3m+qZu4CXUOTOkK4wj3wHd99IeiPpS7Q6C7GmkW7raHKVKOARK79cpyTXtzldN2KVk2sbqElXiDUdufY6Pzo/iwIescpymMuFIlZZOsSCHJwQC0hOxAISCxALBmcdoREldghErLLcBmhDkbE0xCpEmp+7CdCUHrGmxS5IOzrEmk5a7YOkFWJNTKooC/6efrJQEbFqqqnMrFesVaTF5ipZmjycSCudVw2s09/1nOs8xHqZPEtJy/R2lV7X8ACFJD24+xGx8tKYmc/smovelVJjzYNPpc/jQazp803sjwUZaEvWVog1Dx7cnT1IYVC+SNqM9c8Ra7p11XrMcw0RC6kQC37JU5KqH7shjLxPq6ZaRznWl8SaBh/cfRXprGgSq/6ubxPxlHsSq94C/R9Jq4hSkVh1CrWTtIvU7SFWvTxIOqQda6oAseLWTp3OKz676OmEWPWkUxthLIrifVr8KemzmfVmtjGzK8SCIbmR9FHS0cza2gRDrPgsJN0nwbaIFZtHdzd3N0l/SHqb/v6W9EkxdzheSHpvZl0N6TX74j2trjymt933z9OJpK3iPcbVSOrMbB35bpGu8OfC7d19qfMId8T6K3RyIdavBWsl/RVUrgNiVZ5eQeVq0t4QiFW5XB8CNu2u9An1iDW8XFvFO81Lkj6WOjkVsfKxCdquQ6RiHrFenlp90C5xEamYR6zfo1XMQdTGzFrEqje1Toqzp+hz7tNeXYhVqVyt4hwT95wdYtXfJUakGXsIArEuS629Yg4/jC49Yl1O1KUs12OmFmJdnlqdpEdSC7FILcSqJrV6nRcIhrxDHGNEHrGmf4e4GCNREWu41Doq5qJASdqWTi3EGrjbUdz18lvEqje1Ik/1FE0txBperlYxp3qKphZizauQ36bzgBCr0tTaK+ZUz6KU9IiVMR2CtuuuRGohVr7U6jTjqR7EIrUQq8LUijzV0yIWd4i5UmuNWPWm1lFxp3paxKqbqFM9Ta7UQqwyqRV5qqdFrLrlahVzqidLaiEWhXyWdiFW2dTaK+ZUz+CPiyFWeaIOmraIVXdqdYo51TPogxeIRWplSS3EGie1ok71DJZaiMUd4v/aNcQSZsQaL7WOirmB2/UQXTVijZ9aEad6Ln7wwtydnxcGh8QCxALEAsQCQCxALEAsAMQCxALEAkAsQCxALADEAsQCxAJALEAsQCwAxALEAsQCQCxALEAsAMSCePwHBLR1GCBYmhAAAAAASUVORK5CYII=");
    psy_load_bitmap("data:image/png;base64,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");
    psy_load_bitmap("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACgCAYAAADuIpVSAAAACXBIWXMAAAsSAAALEgHS3X78AAABVUlEQVR42u3d0QmAMBBEwazYl61pZ3a2FqFCIDMNSI7H5SuYtgO+thkBwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshAVv7H9/IMk9xjiMeipX29PGwlUIwkJYCAuEhbAQFsICYSEshAXCQlgIC4SFsBAWCAthISwQFsJCWCAshMVassrPxpPMcNDfn7bbWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmEhLIQFwkJYCAuEhbAQFggLYSEsEBbCQlggLISFsEBYCAthgbAQFsICYSEshAXCQlgIC4SFsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyEhbBAWAgLYYGwEBbCAmExmbQ1BWwshIWwQFgIC2GBsBAWwgJhISyEBcJCWAgLhIWwEBYIC2EhLBAWwkJYICyExQIeC6cUN6MSoIEAAAAASUVORK5CYII=");
    setTimeout("blocks" + psy_blockorder + ".run()", 1e3)
}
var blocks1 = {
    blocknumber: 0,
    nblocks: 1,
    run: function () {
        blocks1.blocknumber++;
        switch (blocks1.blocknumber) {
            case 1:
                block_training.start();
                break;
            case 2:
                showdata_html();
                break
        }
    }
};