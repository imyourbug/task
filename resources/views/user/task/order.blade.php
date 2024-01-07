@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    <script type="text/javascript">
        class Product {
            id;
            name;
            quantity;
            price;
            vat;
            constructor(id, name, quantity, price, vat) {
                this.id = id;
                this.name = name;
                this.quantity = quantity;
                this.price = price;
                this.vat = vat;
            }
            setName(name) {
                this.name = name;
            }
            setPrice(price) {
                this.price = price;
            }
            setQuantity(quantity) {
                this.quantity = quantity;
            }
            setVat(vat) {
                this.vat = vat;
            }
        }
        var products = [];

        function getID() {
            if (products.length == 0) {
                return 1;
            }
            return products.pop().id;
        }

        $('.btn-export').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '{{ route('tasks.export') }}',
                data: {

                },
                success: function(response) {
                    if (response.status == 0) {
                        var url = response.url;
                        var filename = response.filename;
                        // var a = $("<a>")
                        //     .attr("href", url)
                        //     .attr("download", filename)
                        //     .appendTo("body");
                        // a.click();
                        // a.remove();
                        $('.download').attr({
                            href: url,
                            download: filename,
                        })
                        $('.download').click();
                        $('.download').on('click', function() {
                            console.log(123);
                        });
                        // window.open(response.url, 'window name', 'window settings');
                    }
                },
            })
        });
    </script>
@endpush
@section('content')
    <div class="card-body">
        <button type="button" class="btn btn-success btn-export">
            Xuất hóa đơn
        </button>
        <table class="table-product">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                </tr>
            <tbody>
                <tr>
                    <td>A</td>
                    <td>A</td>
                    <td>A</td>
                </tr>
            </tbody>
            </thead>
        </table>
    </div>
    <a class="download" href="" download=""></a>
@endsection
