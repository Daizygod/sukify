@extends('layout')

@section('content')
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('tracks') }}">Tracks</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('tracks') }}">View All tracks</a></li>
        </ul>
    </nav>
    <script>
        $( document ).ready(function() {
            $("#artist_id").select2({
                ajax: {
                    type: "get",
                    url: "{{route('getAjax')}}",
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    dataType: 'json',
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById("prevColor");

            const image = new Image();
            const fileReader = new FileReader();
            const canvas = document.getElementById("canvas");

            button.onclick = function(){
                // let imgFile = document.getElementById("cover_file");
                // let file = imgFile.files[0];
                // if (file) {
                //     console.log(file.width);
                // }
                const imgFile = document.getElementById("cover_file");
                const image = new Image();
                const file = imgFile.files[0];
                const fileReader = new FileReader();
            };
            fileReader.onload = () => {
                image.onload = () => {
                    const canvas = document.getElementById("canvas");
                    canvas.width = image.width;
                    canvas.height = image.height;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(image, 0, 0);
                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const rgbArray = buildRgb(imageData.data);
                    const quantColors = quantization(rgbArray, 0);
                    console.log(quantColors);
                }
            }
            // imgFile.addEventListener("change", function () {
            //     console.log(123);
            // });

            function handleFiles() {
                console.log(123);
                canvas.width = image.width;
                canvas.height = image.height;
                console.log(image.width);
                const ctx = canvas.getContext("2d");
                ctx.drawImage(image, 0, 0);
                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const rgbArray = buildRgb(imageData.data);
                const quantColors = quantization(rgbArray, 0);
            }

            fileReader.onload = () => {
                image.onload = () => {
                    const canvas = document.getElementById("canvas");
                    canvas.width = image.width;
                    canvas.height = image.height;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(image, 0, 0);
                    let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const rgbArray = buildRgb(imageData.data);
                    const quantColors = quantization(rgbArray, 0);
                }
            }

            function getMeta(url) {
                const img = new Image();
                img.src = url;
                img.decode();
                return img;
            }

            const buildPalette = (colorsList) => {
                const paletteContainer = document.getElementById("palette");
                const complementaryContainer = document.getElementById("complementary");
                // reset the HTML in case you load various images
                paletteContainer.innerHTML = "";
                complementaryContainer.innerHTML = "";

                const orderedByColor = orderByLuminance(colorsList);
                const hslColors = convertRGBtoHSL(orderedByColor);

                for (let i = 0; i < orderedByColor.length; i++) {
                    const hexColor = rgbToHex(orderedByColor[i]);

                    const hexColorComplementary = hslToHex(hslColors[i]);

                    if (i > 0) {
                        const difference = calculateColorDifference(
                            orderedByColor[i],
                            orderedByColor[i - 1]
                        );

                        // if the distance is less than 120 we ommit that color
                        if (difference < 120) {
                            continue;
                        }
                    }

                    // create the div and text elements for both colors & append it to the document
                    const colorElement = document.createElement("div");
                    colorElement.style.backgroundColor = hexColor;
                    colorElement.appendChild(document.createTextNode(hexColor));
                    paletteContainer.appendChild(colorElement);
                    // true when hsl color is not black/white/grey
                    if (hslColors[i].h) {
                        const complementaryElement = document.createElement("div");
                        complementaryElement.style.backgroundColor = `hsl(${hslColors[i].h},${hslColors[i].s}%,${hslColors[i].l}%)`;

                        complementaryElement.appendChild(
                            document.createTextNode(hexColorComplementary)
                        );
                        complementaryContainer.appendChild(complementaryElement);
                    }
                }
            };

            //  Convert each pixel value ( number ) to hexadecimal ( string ) with base 16
            const rgbToHex = (pixel) => {
                const componentToHex = (c) => {
                    const hex = c.toString(16);
                    return hex.length == 1 ? "0" + hex : hex;
                };

                return (
                    "#" +
                    componentToHex(pixel.r) +
                    componentToHex(pixel.g) +
                    componentToHex(pixel.b)
                ).toUpperCase();
            };

            /**
             * Convert HSL to Hex
             * this entire formula can be found in stackoverflow, credits to @icl7126 !!!
             * https://stackoverflow.com/a/44134328/17150245
             */
            const hslToHex = (hslColor) => {
                const hslColorCopy = {...hslColor};
                hslColorCopy.l /= 100;
                const a =
                    (hslColorCopy.s * Math.min(hslColorCopy.l, 1 - hslColorCopy.l)) / 100;
                const f = (n) => {
                    const k = (n + hslColorCopy.h / 30) % 12;
                    const color = hslColorCopy.l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                    return Math.round(255 * color)
                        .toString(16)
                        .padStart(2, "0");
                };
                return `#${f(0)}${f(8)}${f(4)}`.toUpperCase();
            };

            /**
             * Convert RGB values to HSL
             * This formula can be
             * found here https://www.niwa.nu/2013/05/math-behind-colorspace-conversions-rgb-hsl/
             */
            const convertRGBtoHSL = (rgbValues) => {
                return rgbValues.map((pixel) => {
                    let hue,
                        saturation,
                        luminance = 0;

                    // first change range from 0-255 to 0 - 1
                    let redOpposite = pixel.r / 255;
                    let greenOpposite = pixel.g / 255;
                    let blueOpposite = pixel.b / 255;

                    const Cmax = Math.max(redOpposite, greenOpposite, blueOpposite);
                    const Cmin = Math.min(redOpposite, greenOpposite, blueOpposite);

                    const difference = Cmax - Cmin;

                    luminance = (Cmax + Cmin) / 2.0;

                    if (luminance <= 0.5) {
                        saturation = difference / (Cmax + Cmin);
                    } else if (luminance >= 0.5) {
                        saturation = difference / (2.0 - Cmax - Cmin);
                    }

                    /**
                     * If Red is max, then Hue = (G-B)/(max-min)
                     * If Green is max, then Hue = 2.0 + (B-R)/(max-min)
                     * If Blue is max, then Hue = 4.0 + (R-G)/(max-min)
                     */
                    const maxColorValue = Math.max(pixel.r, pixel.g, pixel.b);

                    if (maxColorValue === pixel.r) {
                        hue = (greenOpposite - blueOpposite) / difference;
                    } else if (maxColorValue === pixel.g) {
                        hue = 2.0 + (blueOpposite - redOpposite) / difference;
                    } else {
                        hue = 4.0 + (greenOpposite - blueOpposite) / difference;
                    }

                    hue = hue * 60; // find the sector of 60 degrees to which the color belongs

                    // it should be always a positive angle
                    if (hue < 0) {
                        hue = hue + 360;
                    }

                    // When all three of R, G and B are equal, we get a neutral color: white, grey or black.
                    if (difference === 0) {
                        return false;
                    }

                    return {
                        h: Math.round(hue) + 180, // plus 180 degrees because that is the complementary color
                        s: parseFloat(saturation * 100).toFixed(2),
                        l: parseFloat(luminance * 100).toFixed(2),
                    };
                });
            };

            /**
             * Using relative luminance we order the brightness of the colors
             * the fixed values and further explanation about this topic
             * can be found here -> https://en.wikipedia.org/wiki/Luma_(video)
             */
            const orderByLuminance = (rgbValues) => {
                const calculateLuminance = (p) => {
                    return 0.2126 * p.r + 0.7152 * p.g + 0.0722 * p.b;
                };

                return rgbValues.sort((p1, p2) => {
                    return calculateLuminance(p2) - calculateLuminance(p1);
                });
            };

            const buildRgb = (imageData) => {
                const rgbValues = [];
                // note that we are loopin every 4!
                // for every Red, Green, Blue and Alpha
                for (let i = 0; i < imageData.length; i += 4) {
                    const rgb = {
                        r: imageData[i],
                        g: imageData[i + 1],
                        b: imageData[i + 2],
                    };

                    rgbValues.push(rgb);
                }

                return rgbValues;
            };

            /**
             * Calculate the color distance or difference between 2 colors
             *
             * further explanation of this topic
             * can be found here -> https://en.wikipedia.org/wiki/Euclidean_distance
             * note: this method is not accuarate for better results use Delta-E distance metric.
             */
            const calculateColorDifference = (color1, color2) => {
                const rDifference = Math.pow(color2.r - color1.r, 2);
                const gDifference = Math.pow(color2.g - color1.g, 2);
                const bDifference = Math.pow(color2.b - color1.b, 2);

                return rDifference + gDifference + bDifference;
            };

            // returns what color channel has the biggest difference
            const findBiggestColorRange = (rgbValues) => {
                /**
                 * Min is initialized to the maximum value posible
                 * from there we procced to find the minimum value for that color channel
                 *
                 * Max is initialized to the minimum value posible
                 * from there we procced to fin the maximum value for that color channel
                 */
                let rMin = Number.MAX_VALUE;
                let gMin = Number.MAX_VALUE;
                let bMin = Number.MAX_VALUE;

                let rMax = Number.MIN_VALUE;
                let gMax = Number.MIN_VALUE;
                let bMax = Number.MIN_VALUE;

                rgbValues.forEach((pixel) => {
                    rMin = Math.min(rMin, pixel.r);
                    gMin = Math.min(gMin, pixel.g);
                    bMin = Math.min(bMin, pixel.b);

                    rMax = Math.max(rMax, pixel.r);
                    gMax = Math.max(gMax, pixel.g);
                    bMax = Math.max(bMax, pixel.b);
                });

                const rRange = rMax - rMin;
                const gRange = gMax - gMin;
                const bRange = bMax - bMin;

                // determine which color has the biggest difference
                const biggestRange = Math.max(rRange, gRange, bRange);
                if (biggestRange === rRange) {
                    return "r";
                } else if (biggestRange === gRange) {
                    return "g";
                } else {
                    return "b";
                }
            };

            /**
             * Median cut implementation
             * can be found here -> https://en.wikipedia.org/wiki/Median_cut
             */
            const quantization = (rgbValues, depth) => {
                const MAX_DEPTH = 4;

                // Base case
                if (depth === MAX_DEPTH || rgbValues.length === 0) {
                    const color = rgbValues.reduce(
                        (prev, curr) => {
                            prev.r += curr.r;
                            prev.g += curr.g;
                            prev.b += curr.b;

                            return prev;
                        },
                        {
                            r: 0,
                            g: 0,
                            b: 0,
                        }
                    );

                    color.r = Math.round(color.r / rgbValues.length);
                    color.g = Math.round(color.g / rgbValues.length);
                    color.b = Math.round(color.b / rgbValues.length);

                    return [color];
                }

                /**
                 *  Recursively do the following:
                 *  1. Find the pixel channel (red,green or blue) with biggest difference/range
                 *  2. Order by this channel
                 *  3. Divide in half the rgb colors list
                 *  4. Repeat process again, until desired depth or base case
                 */
                const componentToSortBy = findBiggestColorRange(rgbValues);
                rgbValues.sort((p1, p2) => {
                    return p1[componentToSortBy] - p2[componentToSortBy];
                });

                const mid = rgbValues.length / 2;
                return [
                    ...quantization(rgbValues.slice(0, mid), depth + 1),
                    ...quantization(rgbValues.slice(mid + 1), depth + 1),
                ];
            };

            function getBiggestColor(colorArray) {
                const stepColor = 15;

                let r = 0;
                let g = 0;
                let b = 0;

                let countRG = 0;
                let countRB = 0;
                let countBG = 0;
                let countR = 0;
                let countG = 0;
                let countB = 0;

                for (let index = 0; index < colorArray.length; ++index) {
                    const element = colorArray[index];
                    r = element["r"];
                    g = element["g"];
                    b = element["b"];

                    if (r - stepColor >= b && g - stepColor >= b) {
                        countRG++;
                    } else if (r - stepColor >= g && b - stepColor >= g) {
                        countRB++;
                    } else if (g - stepColor >= r && b - stepColor >= r) {
                        countBG++;
                    } else if (r - stepColor >= g && r - stepColor >= b) {
                        countR++;
                    } else if (g - stepColor >= r && g - stepColor >= b) {
                        countG++;
                    } else if (b - stepColor >= r && b - stepColor >= g) {
                        countB++;
                    }
                }

                let values = [countRG, countRB, countBG, countR, countG, countB];
                console.log(values)
                let maxIndex = 0;
                let maxFound = false;

                for (var i = 1; i < values.length; i++) {
                    if (values[maxIndex] < values[i]/* && !maxFound*/) {
                        maxIndex = i;
                        maxFound = true;
                    }
                    /*else if (values[maxIndex] = values[i] && maxFound) {
                        //second color maybe
                    }*/
                }

                let result = 'r';

                switch (maxIndex) {
                    case 0:
                        result = 'rg';
                        break;
                    case 1:
                        result = 'rb';
                        break;
                    case 2:
                        result = 'bg';
                        break;
                    case 3:
                        result = 'r';
                        break;
                    case 4:
                        result = 'g';
                        break;
                    case 5:
                        result = 'b';
                        break;
                }

                return result;
            }


            function getColorForBackground(img) {
                let image = getMeta(bigPlayerCover.src);
                canvas.width = image.naturalWidth;
                canvas.height = image.naturalWidth;
                let ctx = canvas.getContext("2d");
                ctx.drawImage(image, 0, 0);

                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const rgbArray = buildRgb(imageData.data);
                const quantColors = quantization(rgbArray, 0);
                console.log(quantColors);
                let biggestColor = getBiggestColor(quantColors);
                console.log(biggestColor);
                switch (biggestColor) {
                    case 'r':
                        quantColors.sort((a, b) => (a.r > b.r && ((a.r - (a.g + a.b)) > (b.r - (b.g + b.b))) ? -1 : 1));
                        break;
                    case 'g':
                        quantColors.sort((a, b) => (a.g > b.g) ? -1 : 1);
                        break;
                    case 'b':
                        quantColors.sort((a, b) => (a.b > b.b) ? -1 : 1);
                        break;
                    case 'rg':
                        quantColors.sort((a, b) => ((a.r > b.r) && (a.g > b.g)) ? 1 : -1);
                        break;
                    case 'rb':
                        quantColors.sort((a, b) => ((a.r > b.r) && (a.b > b.b)) ? 1 : -1);
                        break;
                    case 'bg':
                        quantColors.sort((a, b) => ((a.b > b.b) && (a.g > b.g)) ? 1 : -1);
                        break;
                }
                console.log(quantColors);
                console.log(quantColors[0]);
                return quantColors[0];


                findBiggestColorRange(buildRGB(imageData));

                // console.log(colorThief.getColor(img));
                //
                // fac.getColorAsync(navigationBar.querySelector('img'))
                //     .then(color => {
                //         navigationBar.style.backgroundColor = color.rgba;
                //         navigationBar.style.color = color.isDark ? '#fff' : '#000';
                //     })
                //     .catch(e => {
                //         console.log(e);
                //     });
                // return colorThief.getColor(img);
            }
        })
    </script>
    {!! Form::open([
        'url' => isset($track) ? route('tracks.update', $track) : route('tracks.store'),
        'method' => 'post',
        'id' => 'pohyi_chestno_kakoy_blyat_tut_id',
        'role' => 'form',
        'files' => true,
        //'class' => 'form-control',
        'enctype' => 'multipart/form-data'
    ]) !!}
    @isset($track)
        @method('PUT')
    @endisset
    <div class="form_grid" style="text-align: center">
        <div>
            {!! Form::label('name', null, ['class' => 'control-label']) !!}
            {!! Form::text('name', isset($track->name) ? $track->name : null, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('artist', null, ['class' => 'control-label']) !!}
            {!!
                //TODO: in future need to be added more than 1 artist (multi seleceting nad in db change integer to json)
                Form::select('artist_id', isset($track->artist_id) ? \App\Models\Artist::where(['id' => $track->artist_id])->pluck('name')->toArray()
                : \App\Models\Artist::all()//select('artists.name')
                //->leftjoin('tracks', 'tracks.artist_id', '=', 'artists.id')
                //->groupBy('artists.name', 'artists.id')
                //->orderBy('artists.id', 'asc')
                ->pluck('id', 'name')
                ->toArray(), (isset($track->artist_id) && $track->artist_id != 0) ? $track->artist_id : 1,
                [
                    'class' => 'form-control',
                    'id' => 'artist_id',
                    'multiple' => false
                ]);
            !!}
        </div>
        <div>
            {!! Form::label('release_date', null, ['class' => 'control-label']) !!}
            {!! Form::date('release_date', isset($track->release_date) ? $track->release_date : null, ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('type', null, ['class' => 'control-label']) !!}
            {!! Form::select('type', \App\Models\Track::$types_array, isset($track->type) ? $track->type : 1, ['class' => 'form-control']); !!}
        </div>
        <?php
        if (!isset($track->id)) { ?>
        <div>
            {!! Form::label('counter', null, ['class' => 'control-label']) !!}
            {!! Form::number('counter', isset($track->counter) ? $track->counter : 1, ['class' => 'form-control']); !!}
        </div>
        <?php
        } ?>
        <div>
            {!! Form::label('file', null, ['class' => 'control-label']) !!}
            {!! Form::file('file', ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('video_file', null, ['class' => 'control-label']) !!}
            {!! Form::file('video_file', ['class' => 'form-control']); !!}
        </div>
        <div>
            {!! Form::label('cover_file', null, ['class' => 'control-label']) !!}
            <div style="display: flex">
                {!! Form::file('cover_file', ['class' => 'form-control']); !!}
                <button type="button" id="prevColor" style="margin-left: 10px; border: none; background: linear-gradient(318deg, rgba(9,9,121,1) 0%, rgba(53,139,221,1) 51%, rgba(0,212,255,1) 100%);
                border-radius: 5px;color: white;">color</button>
            </div>
        </div>
        <div>
            {!! Form::label('ui_background_color', null, ['class' => 'control-label']) !!}
            {!! Form::text('ui_background_color', null, ['class' => 'form-control']); !!}
        </div>
        <div style="grid-column: 1 / 3;"><canvas id="canvas"></canvas></div>
    </div>
    {!! Form::submit('Save', ['class' => 'btn btn-success', 'style' => 'width: 100%']); !!}
    {!! Form::close(); !!}
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

</div>
</body>
@endsection
