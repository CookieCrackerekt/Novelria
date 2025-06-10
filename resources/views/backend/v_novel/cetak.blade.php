<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: center;
        vertical-align: middle;
    }

    img {
        max-width: 100px;
        height: auto;
    }
</style>

<table>
    <tr>
        <td align="left">
            Perihal: {{ $judul }} <br>
            Tanggal Awal: {{ $tanggalAwal }} s/d Tanggal Akhir: {{ $tanggalAkhir }}
        </td>
    </tr>
</table>

<p></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Uploader</th>
            <th>Cover Novel</th>
            <th>PDF</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cetak as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->genre->genre_name ?? '-' }}</td>
                <td>{{ $row->user->nama ?? '-' }}</td>
                <td>
                    @if ($row->image_path)
                        <img src="{{ asset($row->image_path) }}" alt="Cover">
                    @else
                        Tidak ada
                    @endif
                </td>
                <td>
                    @if ($row->pdf_path)
                        <a href="{{ asset($row->pdf_path) }}" target="_blank">Lihat PDF</a>
                    @else
                        Tidak ada
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script> window.onload = function () { printStruk(); } function printStruk() { window.print(); } </script>