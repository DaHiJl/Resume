//Картежи

// let color: [number, number, number] = [255,200,198];
// console.log(color[0]);

// let bgcolor, headercolor: [number,number,number, number?];
// bgcolor = [233,123,234,0.54];
// headercolor = [233,254,123];
// console.log(bgcolor, headercolor);

//Перечисление
// enum Month {
//     Jan,
//     Feb,
//     Mar,
//     Apr,
//     May,
//     Jun,
//     Jul,
//     Aug,
//     Sep,
//     Oct,
//     Nov,
//     Dec
// };

// console.log(Month);

// function isItSummer (month: Month){
//     let isSummer: boolean;
//     switch (month) {
//         case Month.Aug:
//         case Month.Jul:
//         case Month.Jun:
//             isSummer = true;
//             break;
//         default:
//             isSummer = false;
//             break;
//     }
//     return isSummer;
// };

// console.log(isItSummer(Month.Aug));
// console.log(isItSummer(6));


//Произвольный тип any
// const json = `{"latitude": 10.11, "longitude":12.12}`;
// const currentLocation = JSON.parse(json);
// console.log(currentLocation);